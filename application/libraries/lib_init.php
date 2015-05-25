<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Executing custom CMS initialication code
 */
class Lib_init {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();

        log_message('debug', "Lib_init Class Initialized");

        //$this->bootstrapInitErrorHandler();

        $this->bootstrapInitAutoloading();
        
        //Symfony\Component\Debug\Debug::enable();

        // Set timezone
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set($this->CI->config->item('default_time_zone'));
        }

        if (file_exists(getModulePath('install') . '/install.php') AND TRUE !== $this->CI->config->item('is_installed')) {
            if ($this->CI->uri->segment(1) != 'install') {
                redirect("/install");
            }
        } else {
            // Load DB
            $this->CI->load->database();

            // Load hooks lib
            $this->CI->load->library('cms_hooks');
        }

        // Fake function for hooks.
        if (!function_exists('get_hook')) {

            function get_hook() {
                return false;
            }

        }

        $native_session = TRUE;

        // Cache engine
        //$this->CI->load->library('mem_cache','','cache');
        $this->CI->load->library('cache');

        if ($native_session == TRUE) {
            // Sessions engine should run on cookies to minimize opportunities
            // of session fixation attack
            ini_set('session.use_only_cookies', 1);

            $this->CI->load->library('native_session', '', 'session');
        } else {
            $this->CI->load->library('session');
        }

        // Redirect to url with out ending slash
        $uri = $this->_detect_uri();
        $first_segment = $this->CI->uri->segment(1);
        if (substr($uri, -1, 1) === '/' && $first_segment !== 'admin' && $uri !== '/') {
            $get_params = '';
            if (!empty($_GET))
                $get_params = '?' . http_build_query($_GET);
            redirect(substr($uri, 0, -1) . $get_params, 'location', 301);
        }

        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }


        // if shop installed ...
        $this->bootstrapInitShop();
    }


    private function bootstrapInitErrorHandler() {
        
        function exception_error_handler($errno, $errstr, $errfile, $errline) {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        }

        set_error_handler("exception_error_handler");
    }

    private function bootstrapInitAutoloading() {

        require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'ClassLoader.php';
        ClassLoader::getInstance()
                ->registerNamespacedPath(APPPATH);

        /**
         * @todo Code is from Codeigniter 3 Dev... On updating to 3 version 
         * this functionallity will be present in framework, so this shoud 
         * be deleted. 
         */
        if ($composer_autoload = $this->CI->config->item('composer_autoload')) {
            if ($composer_autoload === TRUE && file_exists(APPPATH . 'vendor/autoload.php')) {
                require_once(APPPATH . 'vendor/autoload.php');
            } elseif (file_exists($composer_autoload)) {
                require_once($composer_autoload);
            }
        }

        /*
         * Registeting namespaced paths for each module directory
         */
        foreach ($this->CI->config->item('modules_locations') as $ml) {
            ClassLoader::getInstance()->registerNamespacedPath(APPPATH . $ml);
        }
    }

    private function bootstrapInitShop() {

        if (
                FALSE == $this->CI->config->item('is_installed') ||
                FALSE === $shopPath = getModulePath('shop')
        ) {
            return;
        }

        define('SHOP_DIR', $shopPath);

        ClassLoader::getInstance()
                ->registerNamespacedPath(SHOP_DIR . 'models2/generated-classes')
                ->registerClassesPath(SHOP_DIR . 'models2/generated-classes')
                ->registerClassesPath(SHOP_DIR . 'classes')
                ->registerNamespacedPath(SHOP_DIR . 'classes');

        ShopCore::init();

        // Diable CSRF library form web money service
        $this->CI = & get_instance();
        if ($this->CI->uri->segment(1) == 'shop' && $this->CI->uri->segment(2) == 'cart' && $this->CI->uri->segment(3) == 'view' && $_GET['result'] == 'true' && $_GET['pm'] > 0) {
            define('ICMS_DISBALE_CSRF', true);
        }
        // Support for robokassa
        if ($this->CI->uri->segment(1) == 'shop' && $this->CI->uri->segment(2) == 'cart' && $this->CI->uri->segment(3) == 'view' && $_GET['getResult'] == 'true') {
            define('ICMS_DISBALE_CSRF', true);
        }
        // Support for privat
        if ($this->CI->uri->segment(1) == 'shop' && $this->CI->uri->segment(2) == 'order' && $this->CI->uri->segment(3) == 'view' && $_POST) {
            define('ICMS_DISBALE_CSRF', true);
        }
        if ($this->CI->uri->segment(1) == 'shop' && $this->CI->uri->segment(2) == 'cart' && $this->CI->uri->segment(3) == 'view' && $_GET['succes'] == 'true') {
            define('ICMS_DISBALE_CSRF', true);
        }
        if ($this->CI->uri->segment(1) == 'shop' && $this->CI->uri->segment(2) == 'cart' && $this->CI->uri->segment(3) == 'view' && $_GET['fail'] == 'true') {
            define('ICMS_DISBALE_CSRF', true);
        }
        if (isset($_SERVER['HTTP_REFERER']) AND strpos($_SERVER['HTTP_REFERER'] . "", 'facebook.com')) {
            define('ICMS_DISBALE_CSRF', true);
        }
        // Support for privat

        if ($this->CI->uri->segment(1) == 'shop' && $this->CI->uri->segment(2) == 'order' && $this->CI->uri->segment(3) == 'view') {
            define('ICMS_DISBALE_CSRF', true);
        }
        //new payment system
        if (preg_match("/payment_method_/i", $this->CI->uri->segment(1)) || preg_match("/payment_method_/i", $this->CI->uri->segment(2))) {
            define('ICMS_DISBALE_CSRF', true);
        }
    }

    public function _detect_uri() {
        if (!isset($_SERVER['REQUEST_URI'])) {
            return '';
        }

        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
            $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
        } elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
            $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }

        // This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
        // URI is found, and also fixes the QUERY_STRING server var and $_GET array.
        if (strncmp($uri, '?/', 2) === 0) {
            $uri = substr($uri, 2);
        }
        $parts = preg_split('#\?#i', $uri, 2);
        $uri = $parts[0];
        if (isset($parts[1])) {
            $_SERVER['QUERY_STRING'] = $parts[1];
            parse_str($_SERVER['QUERY_STRING'], $_GET);
        } else {
            $_SERVER['QUERY_STRING'] = '';
            $_GET = array();
        }

        if ($uri == '/' || empty($uri)) {
            return '/';
        }

        $uri = parse_url($uri, PHP_URL_PATH);
        return $uri;
    }

}
