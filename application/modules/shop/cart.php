<?php

//(defined('BASEPATH')) OR exit('No direct script access allowed');

use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Shop Cart Controller
 *
 * @uses ShopController
 * @package Shop
 * @copyright 2013 ImageCMS
 * @author <dev
 */
class Cart extends \Cart\BaseCart {

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

    /**
     * Check use deprecated cart methods or not
     * @var boolean
     */
    private $useDeprecated;

    /** Product quantity max number */
    public $maxRange = 20;

    public function __construct() {
        parent::__construct();
        $this->load->library('Form_validation');
        $this->_userId = $this->dx_auth->get_user_id();
        $this->useDeprecated = $this->config->item('use_deprecated_cart_methods');

        if (!$this->useDeprecated) {
            $this->baseCart = \Cart\BaseCart::getInstance();
        }

        /**
         * Setting validation rules
         *
         * This is for let our methods know validation rules(which fields are required, for example),
         * before this method be called, so please set validation rules for your fields here
         * instead of direct cascade setting in "$this->form_validation->set_rules".
         * Example usage see this method "_validateUserInfo".
         */
        $this->validation_rules['userInfo[fullName]'] = 'required|max_length[50]';
        $this->validation_rules['userInfo[phone]'] = 'required';
        $this->validation_rules['userInfo[email]'] = 'valid_email|required|max_length[30]';
        $this->validation_rules['deliveryMethodId'] = 'callback_delivery_method_id_check';
    }

    /**
     * Display cart page.
     *
     * @access public
     */
    public function index() {

        /** Set meta tags */
        $this->load->helper('Form');
        $this->core->set_meta_tags(ShopCore::t(lang('Cart')));
        $this->template->registerMeta("ROBOTS", "NOINDEX, NOFOLLOW");
        $this->core->core_data['data_type'] = 'cart';

        if ($this->useDeprecated) {
            // Make order and clean cart.
            if ($_POST['makeOrder'] == 1) {
                $this->_makeOrder();
            }

            // Recount items

            if ($_POST['recount'] == 1) {
                ShopCore::app()->SCart->recount();
                if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
                    $this->_redirectBack();
                }
            }

            // Create ranges from dropdown list.
            $ranges = range(1, $this->maxRange);

            foreach (SDeliveryMethodsQuery::create()->joinWithI18n(MY_Controller::getCurrentLocale())->enabled()->orderBy('SDeliveryMethods.Position')->find() as $key => $deliveryMethod) {
                if ($key == 0)
                    $firstDel = $deliveryMethod;
                foreach ($deliveryMethod->getPaymentMethodss() as $paymentMethod) {
                    $paymentMethods[$deliveryMethod->getId()][] = $paymentMethod->getId();
                }
            }

            $deliveryMethods = SDeliveryMethodsQuery::create()->joinWithI18n(MY_Controller::getCurrentLocale(), Criteria::LEFT_JOIN)->enabled()->orderBy('SDeliveryMethods.Position')->find();
            foreach ($deliveryMethods as $deliveryMethod) {
                if ($deliveryMethod->getFreeFrom()) {
                    if ($deliveryMethod->getFreeFrom() <= ShopCore::app()->SCart->totalPrice()) {
                        $deliveryMethod->setPrice(0);
                    }
                }
            }

            /** Prepare criteria for getting only active payment methods * */
            $c = new Criteria();
            $c->add('active', 1, Criteria::EQUAL);

            if (isset($_POST['userInfo'])) {
                $data['userInfo'] = $_POST['userInfo'];
            }

            $formData = $this->session->flashdata('formData');

            if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
                $cart_tpl = 'cart';
                $this->session->set_userdata($_POST['userInfo']);
                $this->render($cart_tpl, array(
                    'items' => ShopCore::app()->SCart->loadProducts(),
                    'deliveryMethods' => $deliveryMethods,
                    'paymentMethods' => $firstDel->getPaymentMethodss($c),
                    'paymentMethodsArray' => $paymentMethods,
                    'ranges' => array_combine($ranges, $ranges),
                    'profile' => $this->_getUserProfile(),
                    'isRequired' => $this->_isRequired(),
                    'formData' => !empty($formData) ? $formData : array()
                ));
            }
        } else {
            $order = new \Cart\BaseOrder();

            /** Get delivery methods */
            $deliveryMethods = $order->getDeliveryMethods();

            if (count($deliveryMethods)) {
                $paymentMethods = $deliveryMethods[0]->getPaymentMethodss();
            }

            if ($_POST['deliveryMethodId']) {
                $deliveryMethodsSelesct = $order->getDeliveryMethods($_POST['deliveryMethodId']);
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

            if ($this->baseCart->getTotalPrice() < 0) {
                $this->baseCart->setTotalPrice(0);
            }

            $formData = $this->session->flashdata('formData');

            $data = array(
                'cartPrice' => $this->baseCart->getTotalPrice(),
                'cartOriginPrice' => $this->baseCart->getOriginTotalPrice(),
                'totalItems' => $this->baseCart->getTotalItems(),
                'items' => $items ? $items : array(),
                'paymentMethods' => $paymentMethods,
                'deliveryMethods' => $deliveryMethods,
                'profile' => $this->_getUserProfile(),
                'errors' => $errors,
                'isRequired' => $this->_isRequired(),
                'formData' => !empty($formData) ? $formData : array()
            );

            if (\mod_discount\classes\BaseDiscount::checkModuleInstall()) {
                if ($this->baseCart->gift_error) {
                    $data['gift_error'] = $this->baseCart->gift_error;
                }
                //var_dump($this->baseCart->gift_error);
                if ($this->baseCart->getOriginTotalPrice() != $this->baseCart->getTotalPrice()) {
                    $data['discount'] = $this->baseCart->discount_info;
                    $data['discount_val'] = $this->baseCart->getOriginTotalPrice() - $this->baseCart->getTotalPrice();
                }

                if ($this->baseCart->gift_value) {
                    $data['gift_key'] = $this->baseCart->gift_info;
                    $data['gift_val'] = $this->baseCart->gift_value;

                    $data['discount_val'] -= $data['gift_val'];

                    //Добавляет скрытое поле ключа сертификата для обсчета в make_order
                    jsCode('var newElGift = document.createElement("div");'
                            . 'newElGift.innerHTML = "<input type=\"hidden\" value=\"' . $data['gift_key'] . '\" name=\"giftKey\">";'
                            . 'document.forms[1].appendChild(newElGift);');
                }
            }


            if ($deliveryMethodsSelesct) {
                if ($this->baseCart->getTotalPrice() > $deliveryMethodsSelesct->getFreeFrom()) {
                    $deliveryPrice = $deliveryMethodsSelesct->getPrice();
                } else {
                    $deliveryPrice = 0;
                }
                $data['deliveryMethod'] = $deliveryMethodsSelesct;
                $data['cartPriceDelivery'] = $this->baseCart->getTotalPrice() + $deliveryPrice;
                $data['priceDelivery'] = $deliveryPrice;
                $data['paymentMethods'] = $deliveryMethodsSelesct->getPaymentMethodss();
            }

            /** Render cart page */
            \CMSFactory\assetManager::create()->setData($data)->render($this->tplName);
        }
    }

    /**
     * Add to cart product by variant id
     * @param int $id
     */
    public function addProductByVariantId($id) {
        $this->_addItem(\Cart\CartItem::INSTANCE_PRODUCT, $id);
    }

    /**
     * Add kit to cart
     * @param int $kitId
     */
    public function addKit($kitId) {
        $this->_addItem(\Cart\CartItem::INSTANCE_KIT, $kitId);
    }

    /**
     * Call action Cart Api class 
     * @param string $action
     */
    public function api($action, $value) {
        if (($action && $value) || $action) {
            return \Cart\Api::create()->$action($value);
        } else {
            if ($this->input->is_ajax_request()) {
                return json_encode(array('success' => false, 'errors' => true, 'message' => 'Method not found.'));
            } else {
                $this->core->error_404();
            }
        }
    }

    /**
     * Get product by variant id
     * @param int $id
     * @return array
     */
    public function getProductByVariantId($id) {
        return $this->_getItem(CartItem::INSTANCE_PRODUCT, $id);
    }

    /**
     * Get kit by id
     * @param int $kitId
     * @return array
     */
    public function getKit($kitId) {
        return $this->_getItem(CartItem::INSTANCE_KIT, $kitId);
    }

    /**
     * Remove kit by kit id
     * @param int $kitId
     */
    public function removeKit($kitId) {
        $this->_remove(\Cart\CartItem::INSTANCE_KIT, $kitId);
    }

    /**
     * Remove product by variant id
     * @param int $id
     */
    public function removeProductByVariantId($id) {
        $this->_remove(\Cart\CartItem::INSTANCE_PRODUCT, $id);
    }

    /**
     * Remove all items from cart
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
     */
    public function getPrice() {
        $this->_checkResult($this->baseCart->getTotalPrice());
        return $this->_returnValidPrice($this->data);
    }

    /**
     * Get cart origin price without discounts
     * @return type
     */
    public function getOriginPrice() {
        $this->_checkResult($this->baseCart->getOriginTotalPrice());
        return $this->_returnValidPrice($this->data);
    }

    /**
     * Set total cart price
     * @param float $price
     * @return boolean
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
     */
    private function _isRequired() {
        foreach ($this->validation_rules as $validationKey => $validationValue) {
            if (stristr($validationValue, 'required')) {
                $reqArr[$validationKey] = TRUE;
            } else {
                $reqArr[$validationKey] = FALSE;
            }
        }
        return $reqArr;
    }

    /**
     * Validate and return valid price
     * @param float $price
     * @return type
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
     */
    private function _addItem($instance, $id) {
        $quantity = (boolean) $this->input->post('quantity') ? (int) $this->input->post('quantity') : 1;

        $data = array(
            'instance' => $instance,
            'id' => $id,
            'quantity' => $quantity
        );
        try {
            $result = $this->_checkResult($this->baseCart->addItem($data));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }


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
     */
    private function _redirectBack() {
        redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * Redirect to cart
     */
    private function _redirectToCart() {
        redirect(shop_url('cart'));
    }

    /**
     * Check result received from parent class methods
     * @param array $result
     * @return boolean
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
     */
    private function _getUserProfile() {

        if ($this->useDeprecated) {
            $user_id = $this->dx_auth->get_user_id();
            if (!$user_id) {
                return array(
                    'name' => $this->session->userdata('fullName'),
                    'surname' => $this->session->userdata('surname'),
                    'phone' => $this->session->userdata('phone'),
                    'address' => $this->session->userdata('deliverTo'),
                    'email' => $this->session->userdata('email'),
                );
            } else {
                if ($profile = \SUserProfileQuery::create()->filterById($user_id)->findOne()) {
                    return array(
                        'id' => $profile->getId(),
                        'name' => $profile->getName(),
                        'surname' => '',
                        'phone' => $profile->getPhone(),
                        'address' => $profile->getAddress(),
                        'email' => $profile->getUserEmail()
                    );
                } else {
                    return array();
                }
            }
        } else {
            if (!$this->_userId) {
                return array(
                    'name' => $this->session->userdata('fullName'),
                    'surname' => $this->session->userdata('surname'),
                    'phone' => $this->session->userdata('phone'),
                    'address' => $this->session->userdata('deliverTo'),
                    'email' => $this->session->userdata('email'),
                );
            } else {

                if (!$this->_userId) {
                    return array();
                }

                $profile = SUserProfileQuery::create()->filterById($this->_userId)->findOne();
                $user = $this->db->where('id', $this->_userId)->get('users')->row_array();
                if (!$profile) {
                    return array();
                }

                if (!($email = $profile->getUserEmail())) {
                    $email = $user['email'];
                }

                return array(
                    'id' => $profile->getId(),
                    'name' => $profile->getName(),
                    'surname' => '',
                    'phone' => $profile->getPhone(),
                    'address' => $profile->getAddress(),
                    'email' => $email,
                );
            }
        }
    }

    /**
     * Render order summary Page for User.
     * @param  string $orderSecretKey <p>Order Secret key. Random string</p>
     * @deprecated 4.5.2
     */
    public function view($orderSecretKey = null) {
        redirect(site_url('shop/order/view/' . $orderSecretKey));
    }

    /**
     * Add product to cart from POST data.
     * @deprecated 4.5.2
     * @access public
     */
    public function add($instance = 'SProducts') {
        if (TRUE === parent::add($instance)) {
            if ($this->input->get('mobile') == 1) {
                redirect(shop_url('cart'));
            } else {
                $this->_redirectBack();
            }
        } else {
            $this->core->error_404();
        }
    }

    /**
     * Remove product from cart by ID
     * @access public
     * @deprecated 4.5.2
     * @author <dev
     * @copyright (c) 2013 ImageMCMS
     */
    public function delete() {
        $id = $this->uri->segment($this->uri->total_segments());
        if (TRUE === parent::delete($id)) {
            $this->_redirectBack();
        } else {
            $this->core->error_404();
        }
    }

    /**
     * Save ordered products to database
     * @deprecated 4.5.2
     * @access protected
     * @return void
     */
    protected function _makeOrder() {

        $register = true;
        $order = new SOrders;
        // Validate user data
        if ($this->_validateUserInfo($order) === false) {
            $this->template->add_array(array(
                'errors' => validation_errors(),
            ));
            return false;
        }

        // Check if delivery method exists.
        $deliveryMethod = SDeliveryMethodsQuery::create()
                ->findPk((int) $_POST['deliveryMethodId']);
        if ($deliveryMethod === null) {
            $deliveryMethodId = 0;
            $deliveryPrice = 0;
        } else {
            $freeFrom = $deliveryMethod->getFreeFrom();

            $deliveryMethodId = $deliveryMethod->getId();
            if ($deliveryPrice > $freeFrom) {
                $deliveryPrice = 0;
            } else {
                $deliveryPrice = $deliveryMethod->getPrice();
            }
        }

        // Check if payment method exists.
        $paymentMethod = SPaymentMethodsQuery::create()
                ->findPk((int) $_POST['paymentMethodId']);

        if ($paymentMethod === null) {
            $paymentMethodId = 0;
        } else {
            $paymentMethodId = $paymentMethod->getId();
        }


        // Set user id if logged in
        if ($this->dx_auth->is_logged_in() === true) {
            $order->setUserId($this->dx_auth->get_user_id());
            $user_id = $this->dx_auth->get_user_id();
            $register = false;
        } else {
            $userInfo = $this->_createUser($_POST['userInfo']['email']);
            $order->setUserId($userInfo['id']);
            $user_id = $userInfo['id'];
        }

        $order->setKey(self::createCode());
        $order->setDeliveryMethod($deliveryMethodId);

        $order->setPaymentMethod($paymentMethodId);
        $order->setStatus(1);
        $order->setUserFullName(trim($_POST['userInfo']['fullName']));
        $order->setUserSurname(trim($_POST['userInfo']['surname']));
        $order->setUserEmail($_POST['userInfo']['email']);
        $order->setUserPhone($_POST['userInfo']['phone']);
        $order->setUserDeliverTo($_POST['userInfo']['deliverTo']);
        $order->setUserComment($_POST['userInfo']['commentText']);
        $order->setDateCreated(time());
        $order->setDateUpdated(time());
        $order->setUserIp($this->input->ip_address());

        // products for admin's email (variant_name, quantity, price)
        $products = array();

        // Add products
        foreach (ShopCore::app()->SCart->loadProducts() as $cartItem) {

            $product = array(
                'quantity' => $cartItem['quantity'],
                'price' => $cartItem['price'],
            );

            if ($cartItem['model'] instanceof SProducts) {
                $model = $cartItem['model'];


                $model->setAddedToCartCount($model->getAddedToCartCount() + $cartItem['quantity']);
                $model->save();

                $orderedItem = new SOrderProducts;

                $product['variant_name'] = $cartItem['model']->getName();

                $orderedItem->fromArray(array(
                    'ProductId' => $cartItem['productId'],
                    'VariantId' => $cartItem['variantId'],
                    'ProductName' => $cartItem['model']->getName(),
                    'VariantName' => $cartItem['variantName'],
                    'Quantity' => $cartItem['quantity']));

                $orderedItem->fromArray(array('Price' => $cartItem['price']));

                $order->addSOrderProducts($orderedItem);
            } elseif ($cartItem['model'] instanceof ShopKit) {
                $model = $cartItem['model'];

                //adding main product of kit to the order
                $mp = $model->getMainProduct();
                $mp->setAddedToCartCount($mp->getAddedToCartCount() + $cartItem['quantity']);
                $mp->save();

                $mpV = $mp->getFirstVariant();

                $product['variant_name'] = $mp->getName();

                $orderedItem = new SOrderProducts;
                $orderedItem->fromArray(array(
                    'KitId' => $model->getId(),
                    'ProductId' => $mp->getId(),
                    'VariantId' => $mpV->getId(),
                    'ProductName' => $mp->getName(),
                    'VariantName' => $mpV->getName(),
                    'Quantity' => $cartItem['quantity'],
                    'IsMain' => TRUE,));

                $orderedItem->fromArray(array('Price' => $mpV->getPrice()));

                $order->addSOrderProducts($orderedItem);

                //adding atached products of kit to the order
                foreach ($model->getShopKitProducts() as $shopKitProduct) {
                    $ap = $shopKitProduct->getSProducts();
                    $ap->setAddedToCartCount($ap->getAddedToCartCount() + $cartItem['quantity']);
                    $ap->save();

                    $apV = $ap->getKitFirstVariant($shopKitProduct);

                    $orderedItem = new SOrderProducts;
                    $orderedItem->fromArray(array(
                        'KitId' => $model->getId(),
                        'ProductId' => $ap->getId(),
                        'VariantId' => $apV->getId(),
                        'ProductName' => $ap->getName(),
                        'VariantName' => $apV->getName(),
                        'Quantity' => $cartItem['quantity'],
                        'IsMain' => FALSE,
                            )
                    );

                    $orderedItem->fromArray(array('Price' => $apV->getPrice()));

                    $order->addSOrderProducts($orderedItem);
                }
            }

            $products[] = $product;
        }


        $cart = \Cart\BaseCart::getInstance();



        $order->setTotalPrice($cart->getTotalPrice());
        $order->setOriginPrice($cart->getOriginTotalPrice());
        if ($cart->gift_info) {
            $order->setGiftCertKey($cart->gift_info);
            $order->setGiftCertPrice($cart->gift_value);
        }
        if ($cart->getOriginTotalPrice() != $cart->getTotalPrice()) {
            $order->setdiscount($cart->getOriginTotalPrice() - $cart->getTotalPrice());
        }

        $order->save();

        $orderStatus = new SOrderStatusHistory;
        $orderStatus->setOrderId($order->getId());
        $orderStatus->setStatusId(1);
        $orderStatus->setUserId($user_id);
        $orderStatus->setDateCreated(time());
        $orderStatus->setComment($_POST['userInfo']['commentText']);
        $orderStatus->save();

        $productsForEmail = $this->createProductsInfoTable_($products, $order->getDiscount());

        $checkLink = site_url() . "admin/components/run/shop/orders/createPdf/" . trim($order->getId());

        $emailData = array(
            'userName' => $order->user_full_name,
            'userEmail' => $order->user_email,
            'userPhone' => $order->user_phone,
            'userDeliver' => $order->user_deliver_to,
            'orderLink' => shop_url('order/view/' . $order->key),
            'products' => $productsForEmail,
            'deliveryPrice' => $deliveryPrice,
            'checkLink' => $checkLink,
        );

        \cmsemail\email::getInstance()->sendEmail($order->user_email, 'make_order', $emailData);
        // Send SMS to manager
        //ShopCore::app()->SGCalendarSMS->sendSMS('Новый заказ: '.substr($mes, 0, 35));
        // Clear cart data.
        ShopCore::app()->SCart->removeAll();

        // Set flash data.
        $this->session->set_flashdata('makeOrder', true);
        if ($register === true) {
            $userInfo = $this->_createUser($_POST['userInfo']['email']);
            $order->setUserId($userInfo['id']);
            $user_id = $userInfo['id'];
        }

        // Redirect to view ordered prducts.
        redirect(shop_url('order/view/' . $order->getKey()));
    }

    /**
     * Creates the table with order info for cmsemail 'make_order' template
     * @deprecated 4.5.2
     * @param array $productsInfo
     * @return string html table
     */
    private function createProductsInfoTable_($productsInfo, $discount) {
        // getting the site's default currency
        $CI = &get_instance();
        $res = $CI->db->query("SELECT `symbol` FROM `shop_currencies` WHERE `main` = 1 LIMIT 1");
        $res2 = $res->result_array();
        $defaultCurrency = $res2[0]['symbol'];

        $tdStyle = " style='border: 1px solid #e5e5e5;' ";
        //$tdStyle = "";
        // begining creating the table
        $productsForEmail = "<table cellspacing='0' style='min-width: 400px; border: 1px solid #eaeaea;'>" .
                "<thead>" .
                "   <th{$tdStyle}>Продукт</th>" .
                "   <th{$tdStyle}>Количество</th>" .
                "   <th{$tdStyle}>Цена</th>" .
                "   <th{$tdStyle}>Cумма</th>" .
                "</thead>" .
                "<tbody>";

        $total = 0;
        // adding product rows
        foreach ($productsInfo as $product) {
            $curTotal = $product['price'] * $product['quantity'];
            $total += $curTotal;
            $productsForEmail .= "<tr>" .
                    "<td{$tdStyle}>{$product['variant_name']}</td>" .
                    "<td{$tdStyle}>{$product['quantity']}</td>" .
                    "<td{$tdStyle}>{$product['price']} {$defaultCurrency}</td>" .
                    "<td{$tdStyle}>{$curTotal} {$defaultCurrency}</td>" .
                    "</tr>";
        }

        // if there is a discount
        if (!empty($discount)) {
            $total -= $discount;
            $productsForEmail .= "<tr><td colspan='3'{$tdStyle}>Сумма скидки</td><td{$tdStyle}>{$discount} {$defaultCurrency}</td></tr>";
        }

        // total row
        $productsForEmail .= "<tr><td colspan='3'{$tdStyle}>Общая сумма</td><td{$tdStyle}>{$total} {$defaultCurrency}</td></tr>";
        $productsForEmail .= "</tbody></table>";
        return $productsForEmail;
    }

    /**
     * Create random code.
     * @deprecated 4.5.2
     * @param int $charsCount
     * @param int $digitsCount
     * @static
     * @access public
     * @return string
     */
    public static function createCode($charsCount = 3, $digitsCount = 7) {
        $chars = array('q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm');

        if ($charsCount > sizeof($chars)) {
            $charsCount = sizeof($chars);
        }

        $result = array();
        if ($charsCount > 0) {
            $randCharsKeys = array_rand($chars, $charsCount);

            foreach ($randCharsKeys as $key => $val) {
                array_push($result, $chars[$val]);
            }
        }

        for ($i = 0; $i < $digitsCount; $i++) {
            array_push($result, rand(0, 9));
        }

        shuffle($result);

        $result = implode('', $result);

        if (sizeof(SOrdersQuery::create()->filterByKey($result)->select(array('Key'))->limit(1)->find()) > 0) {
            self::createCode($charsCount, $digitsCount);
        }

        return $result;
    }

    /**
     * Validate user data.
     * @deprecated 4.5.2
     * @return void
     */
    protected function _validateUserInfo($order) {
        $this->form_validation->set_rules('userInfo[fullName]', ShopCore::t('Имя, фамилия'), $this->validation_rules['userInfo[fullName]']);
        $this->form_validation->set_rules('userInfo[email]', ShopCore::t('Email'), $this->validation_rules['userInfo[email]']);
        $this->form_validation->set_rules('userInfo[phone]', ShopCore::t('Телефон'), '');
        $this->form_validation->set_rules('userInfo[deliverTo]', ShopCore::t('Адрес доставки'), '');
        $this->form_validation->set_rules('userInfo[commentText]', ShopCore::t('Комментарий к заказу'), '');
        $this->form_validation->set_rules('deliveryMethodId', ShopCore::t('Способ доставки'), $this->validation_rules['deliveryMethodId']);

        $user = new SUserProfile();
        $this->form_validation = $user->validateCustomData($this->form_validation);
        unset($user);
        $this->form_validation = $order->validateCustomData($this->form_validation);

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @deprecated 4.5.2
     * @param type $deliveryMethodId
     * @return boolean
     */
    function delivery_method_id_check($deliveryMethodId = 0) {
        // Check if delivery method exists.
        $deliveryMethod = SDeliveryMethodsQuery::create()
                ->findPk((int) $deliveryMethodId);

        if ($deliveryMethod === null) {
            $this->form_validation->set_message('delivery_method_id_check', 'Такого способа доставки не существует.');
            return false;
        } else {
            return true;
        }
    }

    /**
     * @deprecated 4.5.2
     */
    public function clear() {
        ShopCore::app()->SCart->removeAll();
        $this->redirectToCart();
    }

    /**
     * @deprecated 4.5.2
     */
    protected function redirectToCart() {
        redirect(shop_url('cart'));
    }

    /**
     * @deprecated 4.5.2
     * @param type $email
     * @return type
     */
    protected function _createUser($email) {
        $userInfo = array('id' => NULL);

        if ((int) ShopCore::app()->SSettings->userInfoRegister == 1) {

            $this->load->model('dx_auth/users', 'user2');
            $password = self::createCode();

            if ($this->dx_auth->is_email_available($email)) {
                $userInfo = $this->dx_auth->register($_POST['userInfo']['fullName'], $password, $email, $_POST['userInfo']['deliverTo'], '', $_POST['userInfo']['phone'], TRUE);
                $userInfo['id'] = NULL;

                if ($query = ShopCore::$ci->user2->get_user_by_email($email) AND $query->num_rows() == 1) {
                    $userInfo['id'] = $query->row()->id;
                    $userInfo['fullName'] = $_POST['userInfo']['fullName'];
                    // Send email to user.
//                    $this->_sendUserInfoMail($userInfo);
                }
            }
        }
        return $userInfo;
    }

    /**
     * Set quantity for product by variant id
     * @param int $vId
     * @return json
     */
    public function setQuantityProductByVariantId($vId) {
        $quantity = ((int) $this->input->get('quantity') > 0) ? (int) $this->input->get('quantity') : 1;
        $data = array(
            'instance' => 'SProducts',
            'id' => $vId
        );

        if (ShopCore::app()->SSettings->ordersCheckStocks == 1) {
            $variant = SProductVariantsQuery::create()->findOneById($vId);
            $quantity = $variant->stock < $quantity ? $variant->stock : $quantity;
        }

        if ($this->_checkResult($this->baseCart->setQuantity($data, $quantity))) {
            return TRUE;
        }
        return FALSE;
    }

}

/* End of file cart.php */
