<?php

/**
 * SSettings - Manager shop settings
 * Run with command:   ShopCore::app()->SWatermark->updateWatermarks();
 */
class SBannerHelper {

    public function __construct() {
        $CI = & get_instance();
        $CI->load->database();
        $CI->load->driver('cache');
    }

    //Banners for main page
    public function getBanners($limit = 3) {
        $CI = & get_instance();

        //       if (($banners_main = $CI->cache->fetch('banners_main', 'banners')) == null) {
        //          echo ShopController::getCurrentLocale();
        $banners_main = $CI->db->select('image, url')
                ->from('shop_banners')
                ->join('shop_banners_i18n', 'shop_banners.id = shop_banners_i18n.id')
                ->where('shop_banners_i18n.locale ', MY_Controller::getCurrentLocale())
                ->where('on_main', 1)
                ->where('active', 1)
                ->where('espdate > ', strtotime(date('Y-m-d')))
                ->order_by('position')
                ->limit($limit)
                ->get()
                ->result_array();

        //           $CI->cache->store('banners_main', $banners_main, false, 'banners');
        //      }
        return $banners_main;
    }

    //Banners for category pages
    function getBannersCat($limit = 3, $id_cat = null) {
        if ($id_cat != NULL) {
            $CI = & get_instance();
            return $CI->db->select('*')
                            ->from('shop_banners')
                            ->join('shop_banners_i18n', 'shop_banners.id = shop_banners_i18n.id')
                            ->where('shop_banners_i18n.locale ', MY_Controller::getCurrentLocale())
                            ->like('categories', 'all')
                            ->or_like('categories', $id_cat)
                            ->where('active', 1)
                            ->where('espdate > ', strtotime(date('Y-m-d')))
                            ->order_by('position')
                            ->limit($limit)
                            ->get()
                            ->result_array();
        } else {
            return null;
        }
    }

}
