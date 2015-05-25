<?php

namespace Category;

use Propel\Runtime\ActiveQuery\Criteria;

(defined('BASEPATH')) OR exit('No direct script access allowed');

class BaseCategory extends \ShopController {

    private $get;
    private $filter;
    private $categoryModel;

    public function __construct(\SCategory $categoryModel, array $get = null) {

        parent::__construct();

        $this->ci = \CI::$APP;

        if (!$this->areAllParentsActive($categoryModel->getId()))
            throw new \Exception('category model not found');

        \ShopCore::$currentCategory = $this->categoryModel;

        $this->categoryModel = $categoryModel;

        $this->get = (null === $get) ? $_GET : $get;

        $this->filter = SFilter::create($categoryModel, $this->get);
    }

    public function getCategory() {

        return $this->categoryModel;
    }

    public function installPagination(array &$data, $basePath, $perPage) {
        /** Pagination */
        $this->ci->load->library('Pagination');
        $pagination = new \SPagination();

        $categoryPagination['base_url'] = $basePath;
        $categoryPagination['total_rows'] = $data['totalProducts'];
        $categoryPagination['per_page'] = $perPage;
        $categoryPagination['last_link'] = ceil($data['totalProducts'] / $perPage);
        include_once "./templates/{$this->config->item('template')}/paginations.php";

        $pagination->initialize($categoryPagination);

        $data['pagination'] = $pagination->create_links();
        $data['page_number'] = $pagination->cur_page;
    }

    /**
     * Checks if all parent categories are active
     * @return boolean
     */
    private function areAllParentsActive($currentCategoryId_) {
        // getting shop category data
        $result = $this->db->select(array('id', 'parent_id', 'active'))->get('shop_category');
        if (!$result) {
            return FALSE;
        }
        $categoriesData = array();
        foreach ($result->result_array() as $row) {
            $categoriesData[$row['id']] = $row;
        }

        // checking all parents `active` value
        $currentCategoryId = $currentCategoryId_;
        while ((int) $currentCategoryId != 0) {
            if ((int) $categoriesData[$currentCategoryId]['active'] == 0) {
                return FALSE;
            }
            $currentCategoryId = $categoriesData[$currentCategoryId]['parent_id'];
        }

        return TRUE;
    }

    public function getProducts($limit = null, $offset = null, $order = null) {

        if (!$this->categoryModel)
            throw new \Exception('category model not found');

        /** Prepare products model */
        $products = \SProductsQuery::create()
                ->addSelectModifier('SQL_CALC_FOUND_ROWS')
                ->filterByCategory($this->categoryModel)
                ->filterByActive(true)
                ->joinWithI18n(\MY_Controller::getCurrentLocale())
                ->joinProductVariant()
                ->withColumn('IF(sum(shop_product_variants.stock) > 0, 1, 0)', 'allstock')
                ->groupById()
                ->joinBrand()
                ->distinct()
                ->orderBy('allstock', Criteria::DESC);

        /** Filter $_GET parameters */
        $this->filter->filterGet();

        /** Filter product by price in $_GET['lp'] and $_GET['rp'] */
        $products = $this->filter->makePriceFilter($products);

        /** Filter products by brands in $_GET['brand'] */
        $products = $this->filter->makeBrandsFilter($products);

        /** Filter products by properties $_GET['p'] */
        $products = $this->filter->makePropertiesFilter($products);

        /** Choode order method (default or get) */
        if (!$order) {
            $order_method = $this->getDefaultSort();
        } elseif (!empty($order)) {
            $order_method = $order;
        }

        /** For order method by get order */
        if ($order_method) {
            $products = $products->globalSort($order_method);
        }

        /** Geting products model from base */
        try {
            $products = $products->offset((int) $offset)
                    ->limit((int) $limit)
                    ->find();
        } catch (\PropelException $exc) {
            show_error($exc->getMessage());
        }

        /** Get total product count according to filter parameters */
        $totalProducts = $this->getTotalRow();

        if (count($products)) {
            /** Prepare arrays for filter.tpl */
            $brands = $this->filter->getBrands();
            $properties = $this->filter->getProperties();
            $priceRange = $this->filter->getPricerange();
        }

        $curMin = $this->get['lp'] ? (int) $this->get['lp'] : (int) $priceRange['minCost'];
        $curMax = $this->get['rp'] ? (int) $this->get['rp'] : (int) $priceRange['maxCost'];

        /** Render category page */
        $data = array(
            'title' => $this->categoryModel->virtualColumns['title'],
            'category' => $this->categoryModel,
            'priceRange' => $priceRange,
            'products' => $products,
            'model' => & $products,
            'totalProducts' => $totalProducts,
            'propertiesInCat' => $properties,
            'brands' => $brands,
            'order_method' => $order_method,
            'minPrice' => (int) $priceRange['minCost'],
            'maxPrice' => (int) $priceRange['maxCost'],
            'curMax' => $curMax,
            'curMin' => $curMin
        );

        return $data;
    }

    /**
     * Get total rows
     * @return int
     */
    private function getTotalRow() {
        $connection = \Propel\Runtime\Propel::getConnection('Shop');
        $statement = $connection->prepare('SELECT FOUND_ROWS() as `number`');
        $statement->execute();
        $resultset = $statement->fetchAll();
        return $resultset[0]['number'];
    }

    /**
     * Get default sort method
     * @return type
     */
    public function getDefaultSort() {
        if ($this->categoryModel) {
            $order_method = $this->categoryModel->getOrderMethod();
            $order_from_db = $this->db->where('id', (int) $order_method)->get('shop_sorting')->result_array();
            $order = $order_from_db[0]['get'];
        }

        if (!empty($order)) {
            return $order;
        } else {
            $order = $this->db
                    ->select('shop_sorting.get')
                    ->from('shop_sorting')
                    ->where('shop_sorting.active', 1)
                    ->order_by('shop_sorting.pos')
                    ->get();
            if ($order) {
                $order = $order->row();
            } else {
                show_error($this->db->_error_message());
            }
            return $order->get;
        }
    }

}
