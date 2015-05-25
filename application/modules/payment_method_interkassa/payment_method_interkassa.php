<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Image CMS
 * Module Frame
 */
class Payment_method_interkassa extends MY_Controller {

    public $paymentMethod;
    public $moduleName = 'payment_method_interkassa';

    public function __construct() {
        parent::__construct();
        $lang = new MY_Lang();
        $lang->load('payment_method_interkassa');
    }

    public function index() {        
        lang('interkassa','payment_method_interkassa');
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

        $publicKey = $paySettings['merchant_id'];
        
        $descr = 'OrderId: ' . $param->id . '; Key: ' . $param->getKey();
        $price = $param->getDeliveryPrice()?($param->getTotalPrice()+$param->getDeliveryPrice()):$param->getTotalPrice();       

        $data = array(
            'ik_co_id' => $publicKey,
            'ik_am' => $price,
            'ik_cur' => \Currency\Currency::create()->getMainCurrency()->getCode(),
            'ik_desc' => $descr,
            'ik_pm_no' => $param->id,
            'ik_suc_u' => site_url() . 'shop/order/view/' . $param->getKey(),
            'ik_pnd_u' => site_url() . 'shop/order/view/' . $param->getKey(),
            'ik_fal_u' => site_url() . 'shop/order/view/' . $param->getKey(),
        );
        
        ksort($data, SORT_STRING); 
        array_push($data, $paySettings['merchant_sig']); 
        $signString = implode(':', $data); 
        $sign_hash = base64_encode(md5($signString, true));
        
        $codeTpl = \CMSFactory\assetManager::create()
                ->setData('data',$data)
                ->setData('signature',$sign_hash)
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
        
        $order_id = $param['ik_pm_no'];
        $userOrder = $ci->db->where('id', $order_id)
                ->get('shop_orders');
        if($userOrder){
            $userOrder = $userOrder->row();
        } else {
            show_error($ci->db->_error_message());
        } 

        $key = $userOrder->payment_method . '_'.$this->moduleName;
        $paySettings = $this->getPaymentSettings($key);        
        
        
        $sigPost = $param['ik_sign'];
        unset($param['ik_sign']);
        ksort($param, SORT_STRING); 
        if($paySettings['test_checkbox']){
            array_push($param, $paySettings['merchant_sig_test']);              
        }else{
            array_push($param, $paySettings['merchant_sig']);            
        }
        $signString = implode(':', $param); 
        $sign_hash = base64_encode(md5($signString, true)); 
            
        if ($sigPost === $sign_hash && $order_id)
                $this->successPaid($order_id, $userOrder);
    }

    /**
     * Save settings
     *
     * @return bool|string
     */
    public function saveSettings(SPaymentMethods $paymentMethod) {
        $saveKey = $paymentMethod->getId() . '_'.$this->moduleName;
        \ShopCore::app()->SSettings->set($saveKey, serialize($_POST['payment_method_interkassa']));

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
