<?php

namespace mobile\collection;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * @uses Search.BaseSearch
 * @author A.Gula <dev
 * @copyright (c) 2013, ImageCMS
 * @package Shop.ImageCMSModule
 */
class Mobile_search extends \Search\BaseSearch {

    protected static $_instance;

    /**
     * @return view
     * @access public
     * @author Kaero
     * @copyright ImageCMS (c) 2013, Kaero <dev
     */
    public function __construct() {
        parent::__construct();
        $lang = new \MY_Lang();
        $lang->load('mobile');
    }

    /**
     * @return view
     * @access public
     * @author Kaero
     * @copyright ImageCMS (c) 2013, Kaero <dev
     */
    public function index() {

        /** Build pagination */
        $this->load->library('Pagination');
        $this->pagination = new \SPagination();
        $searchPagination['base_url'] = mobile_url('search/' . $this->_getQueryString());
        $searchPagination['per_page'] = $this->perPage;
        $searchPagination['total_rows'] = $this->data['totalProducts'];
        $searchPagination['last_link'] = ceil($this->data['totalProducts'] / $this->perPage);
        include_once "./templates/{$this->config->item('template')}/paginations.php";

        $this->pagination->initialize($searchPagination);

        /** Register cannonical link if we are in search */
        if (!empty(\ShopCore::$_GET) || strstr($_SERVER['REQUEST_URI'], '?')) {
            $this->template->registerCanonical(site_url($this->uri->uri_string()));
        }

        /** And say to robot: don't index search pages */
        $this->template->registerMeta('ROBOTS', "NOINDEX, NOFOLLOW");

        /** Set view data */
        $this->data['pagination'] = $this->pagination->create_links();

        /** Register event 'search:load' */
        \CMSFactory\Events::create()->registerEvent($this->data, 'search:load');
        \CMSFactory\Events::runFactory();

        /** Render view for user */
        $this->render('search', $this->data);
    }

    /**
     * @return bool
     * @access public
     * @author Kaero
     * @copyright ImageCMS (c) 2013, Kaero <dev
     */
    public static function init() {
        (null !== self::$_instance) OR self::$_instance = new self();
        return TRUE;
    }

}
