<?php

namespace Search;

use Propel\Runtime\ActiveQuery\Criteria;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Shop Controller
 *
 * @uses \ShopController
 * @package Shop
 * @copyright 2013 ImageCMS
 * @property products SProducts
 */
class BaseSearch extends \ShopController {

    public $data = array();
    protected $textSearch;
    protected $categorySearch;

    public function __construct($text, $categorySearch = null) {
        lang('Бренды');
        parent::__construct();

        $this->textSearch = $text;
        $this->categorySearch = $categorySearch;
    }

    /**
     * Display products list.
     *
     * @access public
     */
    public function getProducts($limit = null, $offset = null, $order = null) {


        \CMSFactory\Events::create()->registerEvent(array('search_text' => $this->textSearch), 'ShopBaseSearch:preSearch');

        $products = \SProductsQuery::create()
                ->joinWithI18n(\MY_Controller::getCurrentLocale(), Criteria::RIGHT_JOIN)
                ->leftJoin('ProductVariant')
                ->joinMainCategory()
                ->where('MainCategory.Active = ?', 1)
                ->groupById()
                ->filterByActive(true);

        $products->condition('numberCondition', 'ProductVariant.Number LIKE ?', '%' . $this->textSearch . '%');
        $products->condition('nameCondition', 'SProductsI18n.Name LIKE ?', '%' . $this->textSearch . '%');
        $products->condition('idCondition', 'SProducts.Id LIKE ?', $this->textSearch);
        $products->where(array('numberCondition', 'nameCondition', 'idCondition'), Criteria::LOGICAL_OR);

        $subCategories = clone($products);

        $subCategories = $subCategories
                ->select('CategoryId')
                ->find()
                ->toArray();

        if ($this->categorySearch)
            $products = $products->filterByCategoryId($this->categorySearch);

        $countCats = array_count_values($subCategories);

        /**
         * Prepare category tree of Main catagory and sub-categories
         */
        if (count($countCats)) {
            $categories = array();
            foreach ($countCats as $key => $value) {

                $category = \SCategoryQuery::create()
                        ->joinWithI18n(\MY_Controller::getCurrentLocale())
                        ->findOneById($key);

                if (!$category instanceof \SCategory) {
                    break;
                }

                foreach ($category->buildCategoryPath(Criteria::ASC, TRUE) as $cat) {
                    $parentCategory = $cat;
                    break;
                }

                if ($parentCategory) {

                    $categories[$parentCategory->getId()][$parentCategory->getName()][] = array(
                        'id' => $category->getId(),
                        'name' => $category->getName(),
                        'count' => $countCats [$category->getId()]
                    );
                }
            }
        }
        //choode order method (default or get)
        if (!$order) 
            $order = $this->getOrder();
        

        //for order method by get order
        $products
                ->distinct()
                ->withColumn('IF(shop_product_variants.stock > 0, 1, 0)', 'allstock')
                ->orderBy('allstock', Criteria::DESC)
                ->globalSort($order);


        $totalProducts = $this->_count($products);

        $products = $products
                ->offset($offset)
                ->limit($limit)
                ->find();

        $this->data = array(
            'products' => $products,
            'totalProducts' => $totalProducts,
            'categories' => $categories,
            'order_method' =>  $order
        );
    }

    /**
     * Count total products in category
     *
     * @param SProductsQuery $object
     * @return int */
    protected function _count(\SProductsQuery $object) {
        $object = clone $object;
        return $object->count();
    }
    
    private function getOrder(){
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

    protected function _getQueryString() {
        $data = array();

        $need = array('text', 'f', 'lp', 'rp', 'brand', 'order', 'category', 'user_per_page');

        foreach ($need as $key => $value) {
            if (isset(\ShopCore::$_GET[$value])) {
                $data[$value] = \ShopCore::$_GET[$value];
            }
        }

        return '?' . http_build_query($data);
    }

}

/* End of file search.php */