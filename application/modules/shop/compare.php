<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Compare Controller
 *
 * @uses ShopController
 * @package Shop
 * @version 0.1
 * @copyright 2010 Siteimage
 * @author <dev
 */
class Compare extends \Compare\BaseCompare {

    public $forCompareIds = array();

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display products for compare
     *
     * @return void
     */
    public function index() {
          $this->render($this->data[template], $this->data);
    }

}

/* End of file compare.php */


