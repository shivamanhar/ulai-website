<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Search Controller
 *
 * @uses ShopController
 * @package Shop
 * @version 0.1
 * @copyright 2013 ImageCMS
 * @author <dev
 */
class Search extends \Search\BaseSearch {

    public function __construct() {

        parent::__construct();
        lang('Бренды');
        $this->load->helper('string');
        
        $this->load->module('core');
        $this->core->set_meta_tags(lang('Поиск'));
        
        $this->core->core_data['data_type'] = 'search';
    }

    /**
     * Display products list.
     *
     * @access public
     */
    public function index() {
                
        $this->perPage = (intval(\ShopCore::$_GET['user_per_page'])) ? intval(\ShopCore::$_GET['user_per_page']) : \ShopCore::app()->SSettings->frontProductsPerPage;

        $search_str = trim(\ShopCore::$_GET['text']);
        $search_str = str_replace('%', '', \ShopCore::$_GET['text']);
        $search_str = str_replace(' ', '%', \ShopCore::$_GET['text']);

        /** Convert to string * */
        if (!is_string($search_str))
            $search_str = (string) $search_str;

        if (mb_strlen($search_str, 'UTF-8') < 2) {
            $search_str = md5(rand(1, 10));
        }

        $baseSearch = new \Search\BaseSearch($search_str, \ShopCore::$_GET['category']);
        
        $baseSearch->getProducts($this->perPage, \ShopCore::$_GET['per_page'], \ShopCore::$_GET['order']);
        
        $this->data = $baseSearch->data;
        
        // Begin pagination
        $this->load->library('Pagination');
        $this->pagination = new SPagination();
        $searchPagination['base_url'] = shop_url('search/' . $this->_getQueryString());
        $searchPagination['total_rows'] = $this->data['totalProducts'];
        $searchPagination['per_page'] = $this->perPage;
        $searchPagination['last_link'] = ceil($this->data['totalProducts'] / $this->perPage);
        $searchPagination['page_query_string'] = TRUE;
        include_once "./templates/{$this->config->item('template')}/paginations.php";

        $this->pagination->initialize($searchPagination);
        $this->data['pagination'] = $this->pagination->create_links();
        // End pagination

        $this->template->registerMeta("ROBOTS", "NOINDEX, NOFOLLOW");

        /** Register event 'search:load' */
        \CMSFactory\Events::create()->registerEvent($this->data, 'search:load');
        \CMSFactory\Events::runFactory();

        $this->render('search', $this->data);

    }

    /**
     * Autocomplete for search
     * @return jsone
     */
    public function ac($locale = NULL) {
        $NextCS = $this->template->get_var('NextCS');
        $NextCSId = $this->template->get_var('NextCSId');
        $locale = $locale ? $locale : \MY_Controller::getCurrentLocale();

        /** Register event 'search:AC' */
        \CMSFactory\Events::create()->registerEvent(array('search_text' => $this->input->post('queryString')), 'search:AC');

        if (mb_strlen($this->input->post('queryString')) >= 3) {

            $res = $this->db
                    ->select('shop_product_variants.product_id as product_id, name, shop_products.url, shop_product_variants.mainImage, shop_product_variants.price as price, shop_product_variants.id')
                    ->join('shop_products_i18n', "shop_products.id = shop_products_i18n.id AND shop_products_i18n.locale='{$locale}'")
                    ->join('shop_product_variants', 'shop_products.id = shop_product_variants.product_id')
                    ->join('shop_category', 'shop_products.category_id = shop_category.id')
                    ->like('name', trim($_POST['queryString']))
                    ->or_like('number', trim($_POST['queryString']))
                    ->or_like('shop_products.id', trim($_POST['queryString']))
                    ->where('shop_products.active', 1)
                    ->where('shop_category.active', 1)
                    ->order_by('shop_product_variants.position')
                    ->group_by('shop_products.id')
                    ->limit(5)
                    ->distinct()
                    ->get('shop_products')
                    ->result_array();

            foreach ($res as $key => $val) {

                $product = \SProductsQuery::create()->findPk($val['product_id']);

                if ($product) {
//                    $res[$key]['price'] = $product->firstVariant->toCurrency();
                    $res[$key]['price'] = \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $product->firstVariant->toCurrency());
                    $res[$key]['mainImage'] = $product->firstVariant->getMainPhoto();
                    $res[$key]['smallImage'] = $product->firstVariant->getSmallPhoto();
                    if ($NextCS != null) {
//                        $res[$key]['nextCurrency'] = $product->firstVariant->toCurrency('Price', $NextCSId);
                        $res[$key]['nextCurrency'] = \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $product->firstVariant->toCurrency('Price', $NextCSId));
                    }
                } else {
                    $res[$key]['price'] = 0;
                }
            }

            $res['queryString'] .= $this->input->post('queryString');

            return json_encode($res);
        } else {
            $this->core->error_404();
        }
    }

}

/* End of file search.php */