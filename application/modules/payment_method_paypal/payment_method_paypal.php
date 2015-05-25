<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Image CMS
 * Module Frame
 */
class Payment_method_paypal extends MY_Controller {

    public $paymentMethod;
    public $moduleName = 'payment_method_paypal';

    public function __construct() {
        parent::__construct();
        $lang = new MY_Lang();
        $lang->load('payment_method_paypal');
    }

    public function index() {        
        lang('Paypal','payment_method_paypal');
        lang('paypal','payment_method_paypal');
    }

    /**
     * Вытягивает данные способа оплаты
     * @param str $key
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
     * Вызывается при редактировании способов оплатыв админке
     * @param int $id ид метода оплаты
     * @param string $payName название payment_method_liqpay
     * @return string
     */
    public function getAdminForm($id, $payName = null) {
        if(!$this->dx_auth->is_admin()){
            redirect('/');
            exit;
        }
        
        $nameMethod = $payName ? $payName : $this->paymentMethod->getPaymentSystemName();
        $key = $id . '_' . $nameMethod;
        $data = $this->getPaymentSettings($key);
        
        $codeTpl = \CMSFactory\assetManager::create()
                ->setData('data',$data)
                ->fetchTemplate('adminForm');

        return $codeTpl;
    }

    /**
     * Формирование кнопки оплаты
     * @param obj $param Данные о заказе
     * @return str
     */
    public function getForm($param) {
        $payment_method_id = $param->getPaymentMethod();
        $key = $payment_method_id . '_' . $this->moduleName;
        $paySettings = $this->getPaymentSettings($key);

        $marchant = $paySettings['merchant'];
        $serverUrl = $paySettings['server_url'];
        $returnUrl = $paySettings['return_url'];
        $descr = 'OrderId: ' . $param->id . '; Key: ' . $param->getKey();
        $price = $param->getDeliveryPrice()?($param->getTotalPrice()+$param->getDeliveryPrice()):$param->getTotalPrice();

        $data = array(
            'marchant' => $marchant,
            'amount' => $price,
            'currency' => \Currency\Currency::create()->getMainCurrency()->getCode(),
            'description' => $descr,
            'order_id' => $param->id,
            'server_url' => site_url() . $this->moduleName.'/callback',
            'result_url' => site_url() . 'shop/order/view/' . $param->getKey(),
        );

        
        $codeTpl = \CMSFactory\assetManager::create()
                ->setData('data',$data)
                ->fetchTemplate('form');

        return $codeTpl;
    }

    /**
     * Метод куда система шлет статус заказа
     */
    public function callback() {
        if ($_POST) {
            $this->checkPaid($_POST);
        }
    }

    /**
     * Метов обработке статуса заказа
     * @param array $param пост от метода callback
     */
    private function checkPaid($param) {  
        $ci = &get_instance();
        
        $order_id = $param['item_number'];
        $userOrder = $ci->db->where('id', $order_id)
                ->get('shop_orders');
        if($userOrder){
            $userOrder = $userOrder->row();
        } else {
            show_error($ci->db->_error_message());
        } 

        
        
        $postdata = "";
        foreach ($param as $key => $value)
            $postdata.=$key . "=" . urlencode($value) . "&";
        $postdata .= "cmd=_notify-validate";
        $curl = curl_init("https://www.sandbox.paypal.com/cgi-bin/webscr"); // https://www.paypal.com/cgi-bin/webscr
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response != "VERIFIED"){
            die('wrong sigin');
        } else {
            $this->successPaid($order_id, $userOrder);
            
        }
        

    }

    /**
     * Save settings
     *
     * @return bool|string
     */
    public function saveSettings(SPaymentMethods $paymentMethod) {
        $saveKey = $paymentMethod->getId() . '_'.$this->moduleName;
        \ShopCore::app()->SSettings->set($saveKey, serialize($_POST['payment_method_paypal']));

        return true;
    }

    /**
     * Переводит статус заказа в оплачено, и прибавляет пользователю
     * оплеченную сумму к акаунту
     * @param int $order_id ид заказа который обрабатывается
     * @param obj $userOrder данные заказа
     */
    private function successPaid($order_id, $userOrder) {  
        $ci = &get_instance();
        $amount = $ci->db->select('amout')
                        ->get_where('users', array('id' => $userOrder->user_id));
        
        if($amount){
            $amount = $amount->row()->amout;
        } else {
            show_error($ci->db->_error_message());
        }
        
        /*Учитывается цена с доставкой*/
//        $amount += $userOrder->delivery_price?($userOrder->total_price+$userOrder->delivery_price):$userOrder->total_price;
        /*Учитывается цена без доставки*/
        $amount += $userOrder->total_price;      
        
        $result = $ci->db->where('id',$order_id)
                ->update('shop_orders', array('paid'=>'1'));
        if($ci->db->_error_message()){
            show_error($ci->db->_error_message());
        }
        
        $result = $ci->db
                ->where('id', $userOrder->user_id)
                ->limit(1)
                ->update('users', array(
                    'amout' => str_replace(',', '.', $amount)
        ));
        if($ci->db->_error_message()){
            show_error($ci->db->_error_message());
        }
    }

    public function autoload() {
        
    }

    public function _install() {  
        $ci = &get_instance();
        
        $result = $ci->db->where('name', $this->moduleName)
                ->update('components', array('enabled' => '1'));
        if($ci->db->_error_message()){
            show_error($ci->db->_error_message());
        }
    }

    public function _deinstall() {  
        $ci = &get_instance();
        
        $result = $ci->db->where('payment_system_name', $this->moduleName)
                        ->update('shop_payment_methods', array(
                                'active'=>'0',
                                'payment_system_name'=>'0',
                                ));
        if($ci->db->_error_message()){
            show_error($ci->db->_error_message());
        }
        
        $result = $ci->db->like('name', $this->moduleName)
                        ->delete('shop_settings');
        if($ci->db->_error_message()){
            show_error($ci->db->_error_message());
        }
        
    }

}

/* End of file sample_module.php */
