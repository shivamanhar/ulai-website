<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * WishList Controller
 *
 * @uses ShopController
 * @package Shop
 * @version 0.1
 * @copyright 2010 Siteimage
 * @author <dev
 */
class Wish_list_api extends ShopController {

    public $maxRange = 100;

    public function __construct() {
        parent::__construct();
        $this->load->library('Form_validation');
        $this->load->module('core');
        $this->_userId = $this->dx_auth->get_user_id();
    }

    /**
     * Add product to WishList from POST data.
     *
     * @access public
     */
    public function add() {
        //check for loginned user
        if (!$this->dx_auth->is_logged_in()) {
            $response = array('success' => FALSE, 'errors' => 'not_logged_in');
            echo json_encode($response);
            exit;
        }

        // Search for product and its variant
        $response = array('success' => true, 'errors' => false);
        $model = SProductsQuery::create()->findPk((int) $_POST['productId_']);
        if ($model !== null && ShopCore::app()->SWishList->countData() < $this->maxRange) {
            ShopCore::app()->SWishList->add(array(
                'model' => $model,
                'variantId' => (int) $_POST['variantId_'],
            ));
        }
        else
            $response['success'] = false;

        $response['count'] = ShopCore::app()->SWishList->countData();
        $response['varid'] = (int) $_POST['variantId_'];

        echo json_encode($response);
    }

    function sync() {
        $arr_data = ShopCore::app()->SWishList->getData();

        $str = '[';
        foreach ($arr_data as $val)
            $str .= '"'.$val[0] . '_' . $val[1] . '",';

        echo rtrim($str, ',') . ']';
    }

    /**
     * Remove product from Wishlist
     */
    public function delete($id) {
        $response = array('success' => true, 'errors' => false);
        ShopCore::app()->SWishList->removeOne($id);
        $response = array('success' => true, 'errors' => false, 'totalPrice' => ShopCore::app()->SWishList->totalPrice());
        echo json_encode($response);
    }

}

/* End of file wish_list.php */
