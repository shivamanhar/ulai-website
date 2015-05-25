<?php

namespace mobile\collection;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * @uses Category.BaseCategory
 * @author Kaero <dev
 * @copyright (c) 2013, ImageCMS
 * @package Shop.ImageCMSModule
 */
class Mobile_category extends \Category\BaseCategory {

    protected static $_instance;

    /**
     * @copyright (c) 2013, ImageCMS
     * @package Shop.ImageCMSModule
     */
    public function __construct() {
        parent::__construct();
        $lang = new \MY_Lang();
        $lang->load('mobile');
    }

    /**
     * @return view
     * @access public
     * @author Kaero <dev
     * @copyright ImageCMS (c) 2013
     */
    public function index() {
        /* Seo block (canonical) */
        if ((!empty(\ShopCore::$_GET) || strstr($_SERVER['REQUEST_URI'], '?')) && (!\ShopCore::$_GET['per_page'])) {
            $this->template->registerCanonical(site_url($this->uri->uri_string()));
        }

        /* Set meta tags */
        $this->core->set_meta_tags(
                $this->categoryModel->makePageTitle(), $this->categoryModel->makePageKeywords(), $this->categoryModel->makePageDesc(), $this->pagination->cur_page, $this->categoryModel->getShowSiteTitle()
        );

        if ($this->input->get('filtermobile')) {
            return $this->mobileFilter();
        }

        /** Begin pagination */
        $this->load->library('pagination');
        $this->pagination = new \SPagination();
        $categoryPagination['base_url'] = mobile_url('category/' . $this->categoryModel->getFullPath() . \SProductsQuery::getFilterQueryString());
        $categoryPagination['total_rows'] = $this->data['totalProducts'];
        $categoryPagination['per_page'] = $this->perPage;
        $categoryPagination['last_link'] = ceil($this->data['totalProducts'] / $this->perPage);
        include_once "./templates/{$this->config->item('template')}/paginations.php";

        $this->pagination->initialize($categoryPagination);

        /** Set data */
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['pageNumber'] = $this->pagination->cur_page;

        /** Register event 'category:load' */
        \CMSFactory\Events::create()->registerEvent($this->data, 'category:load');
        \CMSFactory\Events::runFactory();

        /** Render view for user */
        $this->render($this->templateFile, $this->data);
    }

    /**
     * @return view
     * @access public
     * @author Kaero <dev
     * @copyright ImageCMS (c) 2013
     */
    public function mobileFilter() {

        /** Filter initializing */
        \ShopCore::app()->SFilter->init($this->categoryModel);

        /** Init Brand list */
        $brands = \ShopCore::app()->SFilter->getBrands();

        /** Set data */
        $this->data['category'] = $this->categoryModel;
        $this->data['brands'] = $brands;

        /** Render view for user */
        $this->render('filter', $this->data);
    }

    /**
     * @return bool
     * @access public
     * @author Kaero <dev
     * @copyright ImageCMS (c) 2013
     */
    public static function init() {
        (null !== self::$_instance) OR self::$_instance = new self();
        return TRUE;
    }

}
