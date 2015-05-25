<?php

use Propel\Runtime\ActiveQuery\Criteria;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Shop Cart Controller
 *
 * @uses ShopController
 * @package Shop
 * @copyright 2013 ImageCMS
 * @author <dev
 */
class Order extends \Cart\BaseOrder {
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

    public function __construct() {
        parent::__construct();
        if (!$this->useDeprecated) {
            $this->baseCart = \Cart\BaseCart::getInstance();
        }
    }

    /**
     * Render order summary Page for User.
     * @param  string $orderSecretKey - Order Secret key. Random string
     */
    public function view($orderSecretKey = null) {


        /** Support for YandexMoney */
        if (isset($_POST['notification_type'])) {
            $orderSecretKey = $_POST['label'];
        }


        /** Support for WebMoney */
        if ($_GET['code']) {

            $code = $_GET['code'];

            $model2 = \ShopsettingsQuery::create()->filterByName('%YandexMoneyData')->findOne();
            $result = $model2->getValue();
            $result = unserialize($result);
            $client = $result['client'];
            $account = $result['account'];
            $secret = $result['secret'];
            $redirect_url = shop_url('order/view/') . '/';
            echo $redirect_url;
            require_once(dirname(__FILE__) . '/classes/PaymentSystems/YandexMoney/src/lib/YandexMoney.php');


            $ym = new YandexMoney($account, './ym.log');
            $receiveTokenResp = $ym->receiveOAuthToken($code, $redirect_url, $secret);

            print "<p class=\"output\">";
            if ($receiveTokenResp->isSuccess()) {
                $token = $receiveTokenResp->getAccessToken();
                print "Received token: " . $token;
            } else {
                print "Error: " . $receiveTokenResp->getError();
                die();
            }
            print "</p>";
            print "<p>Notice: after you received access_token you should store it to your app's storage</p>";
        }



        /** Support for Robokassa */
        if (isset($_REQUEST['Shp_orderKey']) && isset($_REQUEST['Shp_pmId'])) {
            $_GET['pm'] = $_REQUEST['Shp_pmId'];
            $orderSecretKey = $_REQUEST['Shp_orderKey'];
        }


        /** Get SOrders Model */
        $model = SOrdersModel::getOrdersByKey($orderSecretKey);
        ($model !== null) OR $this->core->error_404();

        /** Init Payment Systems */
        ShopCore::app()->SPaymentSystems->init($model);
        $post = $this->input->post();

        if ((isset($_GET['pm']) && $_GET['pm'] > 0) or ( isset($post['ik_x_crc'])) or ( isset($_POST['notification_type'])) or ( isset($post['payment']) && isset($post['signature']))) {
            $paymentMethod = SPaymentMethodsQuery::create()->findPk($model->getPaymentMethod());
            $paymentProcessor = ShopCore::app()->SPaymentSystems->loadPaymentSystem($paymentMethod->getPaymentSystemName(), $paymentMethod);
            if ($paymentProcessor instanceof BasePaymentProcessor) {
                $paymentProcessor->processPayment();
            }
        }

        /** Init Payment Method for order */
        if ($model->getSDeliveryMethods() instanceof SDeliveryMethods) {
            $cr = new Criteria();
            $cr->add('active', TRUE, Criteria::EQUAL);
            $cr->add('shop_payment_methods.id', $model->getPaymentMethod(), Criteria::EQUAL);
            $paymentMethods = $model->getSDeliveryMethods()->getPaymentMethodss($cr);
        }

        /** Start Render Template */
        $this->core->set_meta_tags(ShopCore::t(lang('Order view') . ' #' . $model->getId()));

        $this->template->registerMeta("ROBOTS", "NOINDEX, NOFOLLOW");
        $this->template->registerJsScript($this->load->library('lib_seo')->renderGAForCart($model, $this->core->settings));
        $delivery = SDeliveryMethodsQuery::create()
                ->findPk($model->getDeliveryMethod());
        
        if(!empty($delivery)){
            if($delivery->getLocale() !== \MY_Controller::getCurrentLocale()) {
                $delivery->setLocale(\MY_Controller::getCurrentLocale());
            }
        }
        
        if(!empty($paymentMethods['0'])){
            if($paymentMethods['0']->getLocale() !== \MY_Controller::getCurrentLocale()) {
                $paymentMethods['0']->setLocale(\MY_Controller::getCurrentLocale());
            }
        }
        
        if ($delivery) {
            $freeFrom = $delivery->getFreeFrom();
        }
        
        $answerNotification = $this->db
                ->select('message')
                ->where(['name'=>'order','locale' => MY_Controller::getCurrentLocale()])
                ->get('answer_notifications')
                ->first_row()->message;
        
        /** Render template * */
        $this->render('order_view', array(
            'model' => $model,
            'freeFrom' => $freeFrom,
            'paymentMethod' => $paymentMethods['0'],
            'answerNotification' => $answerNotification,
        ));
        
    }
//    public function phone_number_validation($number) {
//        file_put_contents('sadasd.txt', 'asdasd');
//        if(preg_match('/[^\d\-\+\s\)\(]/', $number)){
//            $this->form_validation->set_message('phone_number_validation', lang('numeric'));
//            return FALSE;
//        }
//        return TRUE;
//    }

    /**
     *  Save ordered products to database
     */
    public function make_order() {

        $giftKey = $this->input->post('giftKey');
        $this->load->library('form_validation');
        $this->form_validation->set_message('phone', lang('numeric'));

        $this->form_validation->set_rules('userInfo[fullName]', Fields::Name(), 'required|max_length[50]');
        $this->form_validation->set_rules('userInfo[phone]', Fields::Phone(), 'trim|required|xss_clean|phone');
        $this->form_validation->set_rules('userInfo[email]', Fields::Email(), 'valid_email|required|max_length[30]');
        $this->form_validation->set_rules('userInfo[deliverTo]', lang('Delivery address'), '');
        $this->form_validation->set_rules('userInfo[commentText]', lang('Order comment'), '');

        // If use password, set validation for password fields
        if ((int) $this->input->post('usePassword') === 1) {
            $this->form_validation->set_rules('newPassword', lang('Password'), 'required');
            $this->form_validation->set_rules('newPassconf', lang('Repeat password'), 'required|matches[newPassword]');
        }

        $user = new \SUserProfile();
        $this->form_validation = $user->validateCustomData($this->form_validation);
        unset($user);
        $order = new \SOrders;
        $this->form_validation = $order->validateCustomData($this->form_validation);
        unset($order);

        if ($this->form_validation->run()) {
            /* changing counts of discount applies */
            \CMSFactory\Events::create()->registerEvent(array(), 'Cart:OrderValidated')->runFactory();
            \CMSFactory\Events::create()->removeEvent('Cart:OrderValidated'); //this event is only for discounts

            $cart = \Cart\BaseCart::getInstance();

            $cartItems = $cart->getItems();

            /** Check delivery method. * */
            $deliveryMethod = SDeliveryMethodsQuery::create()
                    ->findPk((int) $_POST['deliveryMethodId']);

            if ($deliveryMethod) {
                $deliveryMethodId = $deliveryMethod->getId();
                if ($deliveryMethod->getDeliverySumSpecified() == 0) {
                    if ($cart->getTotalPrice() > $deliveryMethod->getFreeFrom()) {
                        $deliveryPrice = NULL;
                    } else {
                        $deliveryPrice = $deliveryMethod->getPrice();
                    }
                } else {
                    $deliveryPrice = NULL;
                }
            }

            /** Check if payment method exists.* */
            $paymentMethod = SPaymentMethodsQuery::create()
                    ->findPk((int) $_POST['paymentMethodId']);

            if ($paymentMethod === null) {
                $paymentMethodId = 0;
            } else {
                $paymentMethodId = $paymentMethod->getId();
            }

            /** Set user id if logged in * */
            if ($this->dx_auth->is_logged_in() === true) {
                $user_id = $this->dx_auth->get_user_id();
            } else {
                if ((int) $this->input->post('usePassword') === 1) {
                    $userInfo = $this->_createUser($_POST['userInfo']['email'], $this->input->post('newPassword'));
                } else {
                    $userInfo = $this->_createUser($_POST['userInfo']['email']);
                }
                $user_id = $userInfo['id'];
            }

            /** Prepare order data * */
            $data = array();
            $data['userId'] = $user_id;
            $data['deliveryMethodId'] = $deliveryMethodId;
            $data['deliveryPrice'] = $deliveryPrice;
            $data['paymentMethodId'] = $paymentMethodId;
            $data['userFullName'] = $_POST['userInfo']['fullName'];
            $data['userSurname'] = $_POST['userInfo']['surname'];
            $data['userEmail'] = $_POST['userInfo']['email'];
            $data['userPhone'] = $_POST['userInfo']['phone'];
            $data['userDeliverTo'] = $_POST['userInfo']['deliverTo'];
            $data['userCommentText'] = $_POST['userInfo']['commentText'];
            $data['userIp'] = $this->input->ip_address();

            /** Create new order * */
            //$baseOrder = new \Orders\BaseOrder();
           // try {
                /** Products for admin's email (variant_name, quantity, price) * */
                $products = array();
                $order = $this->create($data, $products);
//            } catch (Exception $exc) {
//                echo $exc->getMessage();
//                log_message('error', 'Order: ' . $exc->getMessage());
//            }

            \CMSFactory\Events::create()->registerEvent(array('order' => $order, 'price' => $order->getTotalPrice()), 'Cart:MakeOrder')->runFactory();

            /** Save to order history table * */
            try {
                $this->saveOrdersHistory($order->getId(), $user_id, $_POST['userInfo']['commentText']);
            } catch (Exception $exc) {
                echo $exc->getMessage();
                log_message('error', 'Order: ' . $exc->getMessage());
            }



            /** Prepare products for email to administrator * */
            $productsForEmail = parent::createProducsInfoTable($cartItems, $order->getDiscount());

            /** Prepare email data * */
            $checkLink = site_url() . "admin/components/run/shop/orders/createPdf/" . trim($order->getId());
            /** Getting the site's default currency symbol * */
            $defaultCurrency = \Currency\Currency::create()->getSymbol();

            $emailData = array(
                'userName' => $order->user_full_name,
                'userEmail' => $order->user_email,
                'userPhone' => $order->user_phone,
                'userDeliver' => $order->user_deliver_to,
                'orderLink' => shop_url('cart/view/' . $order->key),
                'products' => $productsForEmail,
                'deliveryPrice' => $deliveryPrice . ' ' . $defaultCurrency,
                'checkLink' => $checkLink,
                'totalPrice' => $order->getTotalPrice() . ' ' . $defaultCurrency
            );
            
            /*Скидка по сертефикату*/
            if($giftKey){
                $this->gift_discount($giftKey);
            }

            /** Send email * */
            \cmsemail\email::getInstance()->sendEmail($order->user_email, 'make_order', $emailData);

            /** Set flash data* */
            $this->session->set_flashdata('makeOrderForGA', true);
            $this->session->set_flashdata('makeOrderForTpl', true);
            $this->session->set_flashdata('orderMaked', true);
            $this->session->set_flashdata('makeOrderNotif', true);

            if ($_POST['gift_ord'])
                $this->session->set_flashdata('makeOrderGiftKey', $_POST['gift']);

            /** Redirect to view ordered prducts. * */
            redirect(shop_url('order/view/' . $order->getKey()));
            //$this->view($order->getKey());
        } else {
            $this->session->set_flashdata('validation_errors', validation_errors());
            $this->session->set_flashdata('formData', array_merge($_POST['userInfo'], array(
                'deliveryMethodId' => $_POST['deliveryMethodId'],
            )));
            redirect(shop_url('cart'));
        }
    }
    
    private function gift_discount($giftKey){
        if (!\mod_discount\classes\BaseDiscount::checkModuleInstall()) {
            return false;
            }
            
        $discByKey = $this->db
                ->from('mod_shop_discounts')
                ->where('key', $giftKey)
                ->where('active','1')
                ->where('is_gift','1')
                ->join('mod_discount_all_order', 'mod_shop_discounts.id = mod_discount_all_order.discount_id')
                ->get()
                ->row_array();
        
        if(empty($discByKey)){
            return false;
        }
        
        $dateStart  = $discByKey["date_begin"];
        $dateEnd    = $discByKey["date_end"];
        $valType    = $discByKey["type_value"]; // 1-% 2-целое
        $value      = $discByKey["value"];       
        
        
        $lastOrder = $this->db
                ->order_by('id','desc')
                ->get('shop_orders')
                ->row_array();
        
        switch($valType){
            case '1': $giftPrice = $lastOrder["total_price"]*$value/100; break;
            case '2': $giftPrice = $value; break;
            default: $giftPrice = 0; break;
            
        }
        
        $this->db->where('id',$lastOrder['id'])
                ->update('shop_orders',array(
                        'total_price' => str_replace(',', '.', $lastOrder["total_price"]-$giftPrice),
                         'gift_cert_key' => $giftKey,
                         'gift_cert_price' => str_replace(',', '.', $giftPrice),
                         'discount' => '0',
                         'discount_info' => 'product',
                     ));
        $this->db->where('key', $giftKey)
                ->update('mod_shop_discounts',array('active'=>0));
    }

    /**
     * Create new user
     * @param email $email
     * @return array
     */
    protected function _createUser($email, $password = null) {
        $userInfo = array('id' => NULL);
        if ((int) ShopCore::app()->SSettings->userInfoRegister === 1) {

            $this->load->model('dx_auth/users', 'user2');

            if (!$password) {
                $password = self::createCode();
            }

            if ($this->dx_auth->is_email_available($email)) {
                $userInfo = $this->dx_auth->register($_POST['userInfo']['fullName'], $password, $email, $_POST['userInfo']['deliverTo'], '', $_POST['userInfo']['phone'], TRUE);
                $userInfo['id'] = NULL;

                if ($query = ShopCore::$ci->user2->get_user_by_email($email) AND $query->num_rows() == 1) {
                    $userInfo['id'] = $query->row()->id;
                    $userInfo['fullName'] = $_POST['userInfo']['fullName'];
                }
            }
        }
        return $userInfo;
    }

    /**
     * Check if delivery method exists.
     * @param int $deliveryMethodId
     * @return boolean
     */
    public function delivery_method_id_check($deliveryMethodId = 0) {
        $deliveryMethod = \SDeliveryMethodsQuery::create()
                ->findPk((int) $deliveryMethodId);

        if ($deliveryMethod === null) {
            $this->form_validation->set_message('delivery_method_id_check', lang('This method of delivery does not exist'));
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /**
     * Get Payment Methods by ID
     * @param int $deliveryId
     * @return JSON
     * @author <dev
     * @copyright (c) 2013 ImageCMS
     */
    public function getPaymentsMethods($deliveryId = null) {

        if ($deliveryId == null)
            $response = array('success' => false, 'errors' => true, 'message' => 'Delivery id is null.');

        $paymentMethods = \ShopDeliveryMethodsSystemsQuery::create()->filterByDeliveryMethodId($deliveryId)->find();
        foreach ($paymentMethods as $paymentMethod) {
            $paymentMethodsId[] = $paymentMethod->getPaymentMethodId();
        }
        $paymentMethod = \SPaymentMethodsQuery::create()->filterByActive(true)->where('SPaymentMethods.Id IN ?', $paymentMethodsId)->orderByPosition()->find();

        $jsonData = array();
        foreach ($paymentMethod->getData() as $pm) {
            $jsonData[] = array(
                'id' => $pm->getId(),
                'name' => $pm->getName(),
                'description' => $pm->getDescription()
            );
        }
        $response = array('success' => true, 'errors' => false, 'data' => $jsonData);
        return json_encode($response);
    }

    /**
     * Get Payment Methods by ID
     * @param int $deliveryId string tpl
     * @return html
     * @author <dev
     * @copyright (c) 2013 ImageCMS
     */
    public function getPaymentsMethodsTpl($deliveryId = null, $tpl = 'default') {

        if ($deliveryId == null)
            $response = array('success' => false, 'errors' => true, 'message' => 'Delivery id is null.');

        $paymentMethods = \ShopDeliveryMethodsSystemsQuery::create()->filterByDeliveryMethodId($deliveryId)->find();
        foreach ($paymentMethods as $paymentMethod) {
            $paymentMethodsId[] = $paymentMethod->getPaymentMethodId();
        }
        $paymentMethod = \SPaymentMethodsQuery::create()->joinWithI18n(MY_Controller::getCurrentLocale(), Criteria::JOIN)->filterByActive(true)->where('SPaymentMethods.Id IN ?', $paymentMethodsId)->orderByPosition()->find();

        $this->template->assign('payments', $paymentMethod);
        $this->template->display('shop/payments/' . $tpl);
    }

}

/* End of file cart.php */
