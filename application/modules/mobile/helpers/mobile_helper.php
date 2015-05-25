<?php
if (!function_exists('mobile_url')) {

    function mobile_url($url) {
        if (empty($url))
            return '/';
        return site_url('mobile/' . $url);
    }

}

if (!function_exists('mobile_site_address')) {

    function mobile_site_address($url = '') {
        $CI = &get_instance();
        /*         * Get settings from bd and check is mobile version module * */
        $mobileSettingsSerialized = $CI->db->select('settings')->where('name', 'mobile')->get('components')->row_array();

        if (!$mobileSettingsSerialized) {
            return '/';
        }
        
        /** Userialize settings and return mobile version address* */
        $mobileSettings = unserialize($mobileSettingsSerialized['settings']);
        if (!$mobileSettings['MobileVersionAddress'] || !$mobileSettings['MobileVersionON']) {
            return site_url();
        } else {
            return 'http://'.$mobileSettings['MobileVersionAddress'];
        }
    }

}
?>
