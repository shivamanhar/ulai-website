<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Shop Cart Controller
 *
 * @uses ShopController
 * @package Shop
 * @copyright 2013 ImageCMS
 * @author <dev
 */
class Cart_new extends \ShopController {

    /**
     * Validation ruls for cart page form
     * @var array 
     */
    public $validation_rules = array();

    /**
     * Cart tpl name 
     * @var string
     */
    public $tplName = 'cart';

    /**
     * Hold errors from parent class methods
     * @var array 
     */
    public $errors = array();

    /**
     * Hold success data from parent class methods
     * @var array 
     */
    public $data = array();

    /**
     * 
     * @var BaseCart
     */
    protected $baseCart;

    public function __construct() {
        parent::__construct();

        $this->baseCart = \CartNew\BaseCart::getInstance();

    }

    /*     * *************** Remove ******** */

    public function test() {
//        $data = array(
//            'instance' => 'SProducts',
//            'id' => 92,
//            'quantity' => 1,
//        );
//        $data1 = array(
//            'instance' => 'SProducts',
//            'id' => 92,
//        );
//        $data2 = array(
//            'instance' => 'ShopKit',
//            'id' => 16,
//            'quantity' => 5,
//        );
//        $data3 = array(
//            'instance' => 'ShopKit',
//            'id' => 8,
//            'quantity' => 5,
//        );
//        echo '<pre>';
//        var_dump($this->baseCart->addItem($data));
//        echo '</pre>';
//        echo '<pre>';
//        var_dump($this->baseCart->getItem($data1));
//        echo '</pre>';
//        exit;
//        $this->baseCart->removeAll();
//        $this->baseCart->addItem($data);
//         $this->baseCart->removeAll();
//        $this->baseCart->setQuantity(array('instance' => 'SProducts', 'id' => 2251), 11);
//        $this->baseCart->addItem($data2);
//        $this->baseCart->addItem($data3);
        //$this->baseCart->removeItem(array('instance' => 'ShopKit', 'id' => 8));
//        var_dump($this->baseCart->getItems());
//        var_dumps($this->baseCart->getItems());
//        exit;
//
//
//        $items = $this->baseCart->getItems();
//        $itemArray = array();
//        foreach ($items['data'] as $item) {
//            $itemArray[$item->getKey()] = $item->toArray();
//        }
//        echo '<pre>';
//        print_r($itemArray);
//        echo '</pre>';
        //$this->baseCart->removeAll();
        //$this->baseCart->addItem($data2);
//        $this->baseCart->setItemPrice($data, 525);
        $items = $this->baseCart->getItems();
        $itemArray = array();
        foreach ($items['data'] as $item) {
            $itemArray[$item->getKey()] = $item->toArray();
        }
        echo '<pre>';
        print_r($itemArray);
        echo '</pre>';

//        var_dump($this->baseCart->gift);
//        var_dump($this->baseCart->discount_info['result_sum_discount_convert']);
//        var_dump($this->baseCart->getTotalPrice());
//        var_dump($this->baseCart->getOriginTotalPrice());
//        var_dumps($obj->getItems());
//        try {
//            $obj = new \CartNew\SessionStorage();
//            $obj2 = new \CartNew\DBStorage();
//            $data = $obj->getData();
//            var_dumps($obj2->getData());
//            $obj2->remove();
//            var_dumps($data);
//            $obj->remove(1, 218);
//            var_dumps($obj->getData());
//            $obj->setData($data);
//        } catch (Exception $exc) {
//            var_dumps($exc->getTraceAsString());
//            echo $exc->getMessage();
//            log_message('error', 'Cart_new: ' . $exc->getMessage());
//        }
    }

    /**
     * Show cart page
     * @access public
     * @author DevImageCms    
     */
    public function index() {

//        if ($_POST['gift_key']){
//           
//             require_once 'gift.php';
//            $obkGift = new \Gift();
//            
//            $obkGift->get_gift_certificate_new($_POST['gift_key']);
//        }

        /** Set meta tags */
        $this->core->set_meta_tags(lang('Cart'));
        $this->template->registerMeta("ROBOTS", "NOINDEX, NOFOLLOW");
        $order = new \Orders\BaseOrder();

        /** Get delivery methods */
        $deliveryMethods = $order->getDeliveryMethods();

        /** Get payment methods of first delivery method */
        if (count($deliveryMethods)) {
            $paymentMethods = $deliveryMethods[0]->getPaymentMethodss();
        }

        /** Get cart items */
        if ($this->_checkResult($this->baseCart->getItems())) {
            $items = is_array($this->data) ? $this->data : array();
        } else {
            $errors = $this->errors ? $this->errors : '';
        }

        /** Set user information into session */
        $this->session->set_userdata($this->input->post('userInfo'));

        /** Check flash data to contains validation errors */
        if ($this->session->flashdata('validation_errors')) {
            $errors = $this->session->flashdata('validation_errors');
        }

        /** Render cart page */
        $this->render($this->tplName, array(
            'cartPrice' => $this->baseCart->getTotalPrice(),
            'cartOriginPrice' => $this->baseCart->getOriginTotalPrice(),
            'gift_key' => $this->baseCart->gift_info,
            'gift_val' => $this->baseCart->gift_value,
            'discount' => $this->baseCart->discount_info,
            'discount_val' => $this->baseCart->discount_info['result_sum_discount'],
            'items' => $items ? $items : array(),
            'deliveryMethods' => $deliveryMethods,
            'paymentMethods' => $paymentMethods,
            'profile' => $this->_getUserProfile(),
            'errors' => $errors,
            'isRequired' => $this->_isRequired()
        ));
    }

    /**
     * Call action Cart Api class 
     * @param string $action
     * @access public
     * @author DevImageCms
     */
    public function api($action, $value) {
        if (($action && $value) || $action) {
            return \CartNew\Api::create()->$action($value);
        } else {
            if ($this->input->is_ajax_request()) {
                return json_encode(array('success' => false, 'errors' => true, 'message' => 'Method not found.'));
            } else {
                $this->core->error_404();
            }
        }
    }

    /**
     * Add to cart product by variant id
     * @param int $id
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function addProductByVariantId($id) {
        $this->_addItem(\CartNew\CartItem::INSTANCE_PRODUCT, $id);
    }

    /**
     * Add kit to cart
     * @param int $kitId
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function addKit($kitId) {
        $this->_addItem(\CartNew\CartItem::INSTANCE_KIT, $kitId);
    }

    /**
     * Get product by variant id
     * @param int $id
     * @return array
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function getProductByVariantId($id) {
        return $this->_getItem(\CartNew\CartItem::INSTANCE_PRODUCT, $id);
    }

    /**
     * Get kit by id
     * @param int $kitId
     * @return array
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function getKit($kitId) {
        return $this->_getItem(\CartNew\CartItem::INSTANCE_KIT, $kitId);
    }

    /**
     * Remove kit by kit id
     * @param int $kitId
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function removeKit($kitId) {
        $this->_remove(\CartNew\CartItem::INSTANCE_KIT, $kitId);
    }

    /**
     * Remove product by variant id
     * @param int $id
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function removeProductByVariantId($id) {
        $this->_remove(\CartNew\CartItem::INSTANCE_PRODUCT, $id);
    }

    /**
     * Remove all items from cart
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function removeAll() {
        if ($this->_checkResult($this->baseCart->removeAll())) {
            $this->_redirectToCart();
        } else {
            $this->core->error_404();
        }
    }

    /**
     * Get total cart items count 
     * @return int
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function getTotalItemsCount() {
        $count = $this->baseCart->getTotalItems();
        if ($count || $count === 0) {
            if (is_int($count) && $count > 0) {
                return $count;
            } else {
                return 0;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Get cart price with discounts
     * @return type
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function getPrice() {
        return $this->_returnValidPrice($this->baseCart->getTotalPrice());
    }

    /**
     * Get cart origin price without discounts
     * @return type
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function getOriginPrice() {
        return $this->_returnValidPrice($this->baseCart->getOriginTotalPrice());
    }

    /**
     * Set total cart price
     * @param float $price
     * @return boolean
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function setTotalPrice($price) {
        if ((is_numeric($price) && $price > 0)) {
            $this->baseCart->setTotalPrice($price);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Get cart data
     * @return type
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    public function getData() {
        if ($this->_checkResult($this->baseCart->getItems())) {
            return $this->data;
        } else {
            return array();
        }
    }

    /**
     * Return set of required filds in cart form
     * @return boolean
     * @access private
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function _isRequired() {
        $this->validation_rules['userInfo[fullName]'] = 'required|max_length[50]';
        $this->validation_rules['userInfo[phone]'] = 'required';
        
        $this->validation_rules['userInfo[email]'] = 'valid_email|required|max_length[30]';
        $this->validation_rules['deliveryMethodId'] = 'required';
        foreach ($this->validation_rules as $validationKey => $validationValue) {
            if (stristr($validationValue, 'required'))
                $reqArr[$validationKey] = TRUE;
            else
                $reqArr[$validationKey] = FALSE;
        }

        return $reqArr;
    }

    /**
     * Validate and return valid price
     * @param float $price
     * @return type
     * @access private
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function _returnValidPrice($price) {
        if ($price || $price === 0) {
            if (is_numeric($price) && $price > 0) {
                return $price;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    /**
     * Make general remove item from cart
     * @param string $instance
     * @param int $id
     * @access public
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function _remove($instance, $id) {
        if ($id) {
            $data = array(
                'instance' => $instance,
                'id' => $id
            );

            if ($this->_checkResult($this->baseCart->removeItem($data))) {
                $this->_redirectBack();
            } else {
                $this->core->error_404();
            }
        } else {
            $this->core->error_404();
        }
    }

    /**
     * Make general get item from cart
     * @param type $instance
     * @param type $id
     * @return type
     * @access private
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function _getItem($instance, $id) {
        if ($id) {
            $data = array(
                'instance' => $instance,
                'id' => $id
            );
            if ($this->_checkResult($this->baseCart->getItem($data))) {
                return $this->data;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    /**
     * Make general add item to cart
     * @param type $instance
     * @param type $id
     * @access private
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function _addItem($instance, $id) {
        $quantity = (boolean) $this->input->post('quantity') ? (int) $this->input->post('quantity') : 1;

        $data = array(
            'instance' => $instance,
            'id' => $id,
            'quantity' => $quantity
        );

        $result = $this->_checkResult($this->baseCart->addItem($data));
        if ($result == TRUE) {

            if (isset($_POST['redirect'])) {
                $toCart = $_POST['redirect'] == 'cart' ? TRUE : FALSE;
            } else {
                $toCart = FALSE;
            }
            if ($this->input->post('mobile') == 1 || $toCart == TRUE) {
                $this->_redirectToCart();
            } else {
                $this->_redirectBack();
            }
        }

        $this->core->error_404();
    }

    /**
     * Redirect to back url
     * @access private
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function _redirectBack() {
        redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * Redirect to cart
     * @access private
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function _redirectToCart() {
        redirect(shop_url('cart_new'));
    }

    /**
     * Check result received from parent class methods
     * @param array $result
     * @return boolean
     * @access private
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function _checkResult($result = array()) {
        if (is_array($result)) {
            if ($result['success'] == TRUE) {
                if ($result['data']) {
                    $this->data = $result['data'];
                } else {
                    $this->data = '';
                }
                return TRUE;
            }

            if ($result['errors']) {
                $this->errors = $result['message'];
                return FALSE;
            }
        } else {
            $this->errors = 'Not valid results from parent methods';
            return FALSE;
        }
    }

    /**
     * Get user profile data
     * @return array
     * @access private
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function _getUserProfile() {
        $user_id = $this->dx_auth->get_user_id();
        if (!$user_id) {
            return array(
                'name' => $this->session->userdata('fullName'),
                'phone' => $this->session->userdata('phone'),
                'address' => $this->session->userdata('deliverTo'),
                'email' => $this->session->userdata('email'),
            );
        } else {
            if ($profile = \SUserProfileQuery::create()->filterById($user_id)->findOne()) {
                return array(
                    'id' => $profile->getId(),
                    'name' => $profile->getName(),
                    'phone' => $profile->getPhone(),
                    'address' => $profile->getAddress(),
                    'email' => $profile->getUserEmail()
                );
            } else {
                return array();
            }
        }
    }

}

/* End of file cart_new.php */
