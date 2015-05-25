<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Image CMS
 * Module Sample
 */
class Payment_method_privat24 extends MY_Controller {

    public $paymentMethod;
    private $merchantIdKey;
    private $secretKey;
    public $moduleName = 'payment_method_privat24';
    public $filename = 'uploads/file.txt';
    

    public function __construct() {
        parent::__construct();
        $lang = new MY_Lang();
        $lang->load('payment_method_privat24');
    }
    
    
    public function index() {
        lang('privat24','payment_method_privat24');	
    }
    
    
    /**
        * Отримуємо дані про спосіб оплати: за назвою метода отримуємо мерчант і секретний ключ користувача картки
        * @param string $key
        * @return array
        */
    private function getPaymentSettings($key) {
        $ci = &get_instance();
        $value = $ci->db->where('name', $key)
                ->get('shop_settings');
        if ($value) {
            $value = $value->row()->value;
        } else {
            show_error($ci->db->_error_message());
        }               
        return unserialize($value);
    }
    
    /**
        * Отримуємо форму адміна при підключенні оплати 
        * @param int $id способу оплати
        * @return array та форму з даними цього масиву
        */
    
    public function getAdminForm( $id , $payName = null ){
	if(!$this->dx_auth->is_admin()){
            redirect('/');
            exit;
        }

        $nameMethod = $payName ? $payName : $this->paymentMethod->getPaymentSystemName();
        $key = $id . '_' . $nameMethod;
        $data = $this->getPaymentSettings($key);
        
        return '<div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Merchant ID', 'payment_method_privat24') . ':</label>
                <div class="controls">
                 <input type="text" name="payment_method_privat24[merchant_id]" value="' . $data['merchant_id'] . '"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Merchant secret key', 'payment_method_privat24') . ':</label>
                <div class="controls">
                 <input type="text" name="payment_method_privat24[merchant_sig]" value="' . $data['merchant_sig'] . '" />
                </div>
            </div>';
    }
    
    /**
        *  Виводить кнопку "Оплатити" при замовленні товару
        * @param type $param
        * @return type
        */
    
    public function getForm($param){
        
        $model = \SOrdersQuery::create()->filterById($param->getId())->findOne();
        $data['summ'] = $param->getDeliveryPrice()?($param->getTotalPrice()+$param->getDeliveryPrice()):$param->getTotalPrice();
        $data['currId'] = \Currency\Currency::create()->getMainCurrency()->getCode();
        $data['orderId'] = $param->getId();
        $data['desc'] = 'OrderId: ' . $param->id . '; Key: ' . $param->getKey();
        $data['resultUrl'] = 'http://' . $_SERVER['HTTP_HOST'] . '/shop/order/view/' . $param->getKey();
        $data['serverUrl'] = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $this->moduleName . '/callback';
	
	$id = $param->getPaymentMethod();
        $key = $id . '_' . $this->moduleName;
	$userData = $this->getPaymentSettings($key);

	$this->merchantIdKey = $userData['merchant_id'];
        
        return '
            <form id="paidForm" action="https://api.privatbank.ua/p24api/ishop" method="POST">      
                <input type="hidden" name="amt" value="' . $data['summ'] . '"/>
                <input type="hidden" name="ccy" value="' . $data['currId'] . '" />
                <input type="hidden" name="merchant" value="' . $this->merchantIdKey . '" />
                <input type="hidden" name="order" value="' . $data['orderId'] . '" />
                <input type="hidden" name="details" value="' . $data['desc'] . '" />
                <input type="hidden" name="ext_details" value="' . $data['desc'] . '" />
                <input type="hidden" name="pay_way" value="privat24" />
                <input type="hidden" name="return_url" value="' . $data['resultUrl'] . '" />
                <input type="hidden" name="server_url" value="' . $data['serverUrl'] . '" />
                <div class="btn-cart btn-cart-p">
                    <input type="submit" value="Оплатить">
                </div>
            </form>
        ';
    }
    
    /**
        * Результат оплати повертається в цю функцію у вигляді $_POST
        */
    
    public function callback(){
        if($_POST) {
            $this->checkPaid($_POST);
        }
    }
    
    /**
        * Відбувається перевірка отриманого результату від приват банку  
        * @param array $data - отриманий результат оплати
        */
    
    public function checkPaid($data) {
        $payment = $data['payment'];
        parse_str($data['payment'], $output);
        $order_id = $output['order'];

        $ci = &get_instance();
        $userOrder = $ci->db->where('id', $order_id)
                ->get('shop_orders');
        if($userOrder){
            $userOrder = $userOrder->row();
        } else {
            show_error($ci->db->_error_message());
        } 

        $key = $userOrder->payment_method . '_'.$this->moduleName;
        $paySettings = $this->getPaymentSettings($key);

        $signature = sha1(md5($payment . $paySettings['merchant_sig']));

        // Якщо оплата успішна
        if ($signature == $data['signature']) {
            $this->successPaid($order_id, $userOrder);
        }
    }
    
    /**
        * Успішна оплата 
        * @param int $order_id - id замовлення
        * @param array $userOrder - інформація замовлення користувача
        */

    public function successPaid($order_id, $userOrder) {
        $ci = & get_instance();

        $amout = $ci->db->select('amout')
                ->get_where('users', array('id' => $userOrder->user_id));  
        if($amout){
            $amout = $amout->row()->amout;
        } else {
            show_error($ci->db->_error_message());
        }

        $amout += $userOrder->total_price;

        $amout = str_replace(',', '.', $amout);

        $result = $ci->db->where('id', $order_id)
                ->update('shop_orders', array('paid' => '1'));

        if (!$result) {
            show_error($ci->db->_error_message());
        }

        $result = $ci->db
                ->where('id', $userOrder->user_id)
                ->limit(1)
                ->update('users', array(
            'amout' => $amout
        ));

        if (!$result) {
            show_error($ci->db->_error_message());
        }
    }
    
    /**
        * Збереження конфігурація платжіної системи в БД
        * @param SPaymentMethods $paymentMethod
        * @return boolean
        */
            
    public function saveSettings(SPaymentMethods $paymentMethod) {
        $saveKey = $paymentMethod->getId() . '_payment_method_privat24';
        \ShopCore::app()->SSettings->set($saveKey, serialize($_POST['payment_method_privat24']));

        return true;
    }
    
    public function autoload() {
        
    }
    

    public function _install() {
        $ci = &get_instance();
        $result = $ci->db->where('name', 'payment_method_privat24')
                 	 ->update('components', array('enabled' => '1'));
	if(!$result){
	    show_error($ci->db->_error_message());	
	}
    }
    

    public function _deinstall() {
        $ci = &get_instance();
        
        $ci->db->where('name', $this->moduleName)
                ->update('shop_payment_methods', array(
                        'active'=>'0',
                        'payment_system_name'=>'0',
                ));        
        
        $ci->db->like('name', $this->moduleName)
               ->delete('shop_settings');
    }

}

/* End of file sample_module.php */
