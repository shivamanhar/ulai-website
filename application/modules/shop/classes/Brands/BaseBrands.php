<?php

namespace Brands;

use Propel\Runtime\ActiveQuery\Criteria;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Shop Controller
 *
 * @uses \ShopController
 * @package Shop
 * @copyright 2013 ImageCMS
 * @property \SProducts $model
 */
class BaseBrands extends \ShopController {

    public $data = null;
    public $model;
    public $brandPath;
    public $templateFile = 'brand';
    public $category = '';

    public function __construct() {
        parent::__construct();
        // Load per page param
        $this->locale = \MY_Controller::getCurrentLocale();
        if (\MY_Controller::getCurrentLocale() == \MY_Controller::defaultLocale()) {
            $i = 4;
        } else {
            $i = 5;
        }
        if ($this->uri->total_segments() == $i) {
            $this->category = $this->uri->segment($i) ? : "";
            $this->brandPath = $this->uri->segment($this->uri->total_segments() - 1);
        } else {
            $this->category = $this->uri->segment($i) ? : "";
            $this->brandPath = $this->uri->segment($this->uri->total_segments());
        }

        // Load per page param
        $this->perPage = $this->input->get('user_per_page')? : \ShopCore::app()->SSettings->frontProductsPerPage;

        $this->model = $this->_loadBrand($this->brandPath);

        $_GET['category'] = $this->category;

        if ($this->category) {
            $this->REQUEST_URI = $_SERVER['REQUEST_URI'] . '/' . $this->category;
        } else {
            $this->REQUEST_URI = $_SERVER['REQUEST_URI'];
        }

        if ($this->model != null) {
            $this->__CMSCore__();
        }

        $this->index();

        exit;
    }

    /**
     * Display product info.
     *
     * @access public
     */
    public function __CMSCore__() {
        $this->core->core_data['data_type'] = 'brand';
        $this->core->core_data['id'] = $this->model->getId();
        $this->perPage = (intval(\ShopCore::$_GET['user_per_page'])) ? intval(\ShopCore::$_GET['user_per_page']) : $this->perPage = \ShopCore::app()->SSettings->frontProductsPerPage;

        $this->db->cache_on();

        $products = \SProductsQuery::create()
                ->addSelectModifier('SQL_CALC_FOUND_ROWS')
                ->filterByActive(true)
                ->filterByBrandId($this->model->getId())
                ->joinWithI18n($this->locale)
                ->joinProductVariant()
                ->joinMainCategory()
                ->where('MainCategory.Active = ?', 1)
                ->withColumn('IF(sum(shop_product_variants.stock) > 0, 1, 0)', 'allstock')
                ->groupById()
                ->distinct()
                ->orderBy('allstock', Criteria::DESC);

        $this->db->cache_off();
        //for found in categories
        $incategories = clone $products;
        $incategories = $incategories->select(array('CategoryId', 'Id'))->distinct()->find()->toArray();
        if (count($incategories) > 0) {
            foreach ($incategories as $key => $value) {
                unset($incategories[$key]['Id']);
                $incategories[$key] = $value['CategoryId'];
            }
            $incategories = array_count_values($incategories);
        }

        if ($this->category) {
            $this->template->registerCanonical(site_url('shop/brand') . '/' . $this->model->getUrl());
            $products->filterByCategoryId($this->category);
        }

        //choode order method (default or get)
        if (!\ShopCore::$_GET['order']) {
            $order_method = \Category\BaseCategory::getDefaultSort();
            // $order_method = $order_method->get;
        } elseif (!empty(\ShopCore::$_GET['order'])) {
            $order_method = \ShopCore::$_GET['order'];
        }

        //for order method by get order
        if ($order_method) {
            $products = $products->globalSort($order_method);
        }

        try {
            $products = $products->offset((int) \ShopCore::$_GET['per_page'])
                    ->limit((int) $this->perPage)
                    ->find();
        } catch (\PropelException $exc) {
            show_error($exc->getMessage());
        }


        /**
         * Prepare category tree of Main catagory and sub-categories
         */
        $count_cats = $incategories;
        $totalProducts = $this->getTotalRow();

        $categories = array();
        $count = 0;
        foreach ($count_cats as $key => $value) {
            $category = \SCategoryQuery::create()->filterById($key)
                    ->joinWithI18n(\MY_Controller::getCurrentLocale())
                    ->filterByActive(TRUE)
                    ->findOne();

            foreach ($category->buildCategoryPath() as $cat) {
                $parentCategory = $cat;
                break;
            }

            if ($parentCategory) {

                $categories[$parentCategory->getId()][$parentCategory->getName()][] = array(
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                    'count' => $count_cats[$category->getId()]
                );
//                $categories[$parentCategory->getId()][$parentCategory->getName()]['count'] += $count_cats[$category->getId()];
            }
        }

//        $totalProducts = $this->getTotalRow();
//        var_dumps($products->getCategoryId());
        $this->data = array(
            'categories' => $categories,
            'template' => $this->templateFile,
            'model' => $this->model,
            'priceRange' => $priceRange,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'incats' => $incategories,
            //'categories_names' => $cat_names,
            'propertiesInCat' => $properties,
//            'categoriesInBrand' => $categories,
            'tree' => \ShopCore::app()->SCategoryTree->getTree(),
            'order_method' => $order_method
        );
    }

    protected function _loadBrand($url) {
        $brands = \SBrandsQuery::create()
                ->joinWithI18n(\MY_Controller::getCurrentLocale())
                ->filterByUrl($url)
                ->findOne();
        return $brands;
    }

    private function getTotalRow() {
        $connection = \Propel\Runtime\Propel::getConnection('Shop');
        $statement = $connection->prepare('SELECT FOUND_ROWS() as `number`');
        $statement->execute();
        $resultset = $statement->fetchAll();
        return $resultset[0]['number'];
    }

    public function renderImageList() {
        $model = $this->db
                ->join('shop_brands_i18n', 'shop_brands_i18n.id=shop_brands.id')
                ->order_by('name')
                ->where('locale', $this->locale)
                ->where('image <>', '')
                ->get('shop_brands')
                ->result_array();

        $this->render('brands_images', array(
            'model' => $model
        ));
        exit;
    }

    public function renderNamesList() {
        $alphabet = array(
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й',
            'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф',
            'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Э', 'Ю', 'Я', 'A', 'B', 'C',
            'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
            'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y',
            'Z'
        );

        $array = $this->db
                ->join('shop_brands_i18n', 'shop_brands_i18n.id=shop_brands.id')
                ->order_by('name')
                ->where('locale', $this->locale)
                ->get('shop_brands')
                ->result_array();
        $this->db->cache_off();

        $model = array();
        foreach ($array as $key => $m)
            $model[strtoupper($m['name'][0])][$key] = $m;

        $all_count = 0;
        foreach ($alphabet as $key => $char) {
            if ($model[$char] != null) {
                $all_count++;
                $all_count += count($model[$char]);
            }
        }


        $iteration = floor($all_count / 5);

        $this->render('brands_list', array(
            'model' => $model,
            'alphabet' => $alphabet,
            'all_count' => $all_count,
            'iteration' => $iteration
        ));
        exit;
    }

}

/* End of file BaseBrands.php */