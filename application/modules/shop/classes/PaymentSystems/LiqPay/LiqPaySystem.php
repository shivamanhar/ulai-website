<?php

/**
 * Robokassa payment module
 *
 * author: dev
 * more info at: http://www.robokassa.ru/HowTo.aspx
 */
class LiqPaySystem extends BasePaymentProcessor {

    protected $settigns = null;

    public function __construct() {
        $this->order = ShopCore::app()->SPaymentSystems->getOrder();
        $lang = new MY_Lang();
        $lang->load('main');
    }

    /**
     * Process payment.
     */
    public function processPayment() {
        // Check if order is paid.
        if ($this->order->getPaid() == true)
            return ERROR_ORDER_PAID_BEFORE;

        $data = $this->loadSettings();
		$public_key = $data['merchant_id'];
        //$mrh_pass2 = $data['password2'];

        $shp_order_key = $this->order->getKey();
        $shp_payment_id = $this->paymentMethod->getId();
	$out_summ =  $_REQUEST["amount"];
        $inv_id = $_REQUEST["order_id"];
        $crc = strtoupper($_REQUEST["crc"]);	


        $my_crc = strtoupper(md5("$out_summ:$inv_id:$shp_order_key:$shp_payment_id:$public_key"));

		
        // Check sum
		// ціна доставки
        $deliveryPrice = $this->order->getDeliveryPrice();
        if ($out_summ != \Currency\Currency::create()->convert($deliveryPrice + $productsPrice, $this->paymentMethod->getCurrencyId()))
            return ERROR_SUM;

        // Check sign
        if ($my_crc != $crc)
            return "bad sign $out_summ:$inv_id:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id";

        // Set order paid
        $this->setOrderPaid();

        // Show answer for Robokassa API service
        if (isset($_REQUEST['getResult']) && $_REQUEST['getResult'] == 'true') {
            echo "OK" . $this->order->getId();
            exit();
        }


        if (empty($_POST['operation_xml']) && empty($_POST['signature '])) {
            $this->setOrderPaid();
        }
        return true;
    }

    /**
     * Create payment form
     *
     * @return string Generated form
     */
    public function getForm() {
        $data = $this->loadSettings();

        // Оплата заданной суммы с выбором валюты на сайте LiqPay
        // регистрационная информация (логин, пароль #1)
        $public_key = $data['merchant_id'];
        $private_key = $data['merchant_sig'];
        $shp_order_key = $this->order->getKey();
        $shp_payment_id = $this->paymentMethod->getId();
		
        $productsPrice = $this->order->getTotalPrice();
        // ціна доставки
        $deliveryPrice = $this->order->getDeliveryPrice();
        $out_summ = \Currency\Currency::create()->convert($deliveryPrice + $productsPrice, $this->paymentMethod->getCurrencyId());      
	   // номер заказа
        $inv_id = $this->order->getId();		
		//шифр
		$crc = md5("$out_summ:$inv_id:$shp_order_key:$shp_payment_id:$public_key");

		$result_url = shop_url('order/view/'.$shp_order_key.'?result=true&amp;pm=' . $this->paymentMethod->getId() . '&amp;crc='.$crc. '&amp;amount='.$out_summ. '&amp;order_id='.$inv_id);
		
		$server_url = site_url().'shop/order';
		$type = "buy";
		$language = "ru";
		$lang = new MY_Lang();
		// $language1 = $lang->getLangCode();
		if($language1[0] == 'en'){$language = "en";}else($language == 'ru');
		


        // описание заказа
        $inv_desc = "Оплата заказа номер " . $this->order->getId();
		

        // сумма заказа
        //$out_summ = \Currency\Currency::create()->convert($this->order->getTotalPrice(), $this->paymentMethod->getCurrencyId());
		
		// ціна доставки
        $deliveryPrice = $this->order->getDeliveryPrice();
        $out_summ = \Currency\Currency::create()->convert($deliveryPrice + $productsPrice, $this->paymentMethod->getCurrencyId());

        // предлагаемая валюта платежа
        $ISOCode = SCurrenciesQuery::create()->filterByIsDefault(true)->findOne()->getCode();

		
        // форма оплаты товара
		$inv = $private_key . $out_summ . $ISOCode . $public_key . $inv_id . $type . $inv_desc . $result_url . $server_url;
		$inv = html_entity_decode($inv);
		$signature = base64_encode(sha1($inv,1));
		

		$xml = "<form method='POST' action='https://www.liqpay.com/api/pay' target='_blank' accept-charset='utf-8'>
		  <input type='hidden' name='public_key' value='$public_key' />
		  <input type='hidden' name='amount' value='$out_summ' />
		  <input type='hidden' name='currency' value='$ISOCode' />
		  <input type='hidden' name='description' value='$inv_desc' />
		  <input type='hidden' name='order_id' value='$inv_id' />
		  <input type='hidden' name='result_url' value='$result_url' />
		  <input type='hidden' name='server_url' value='$server_url' /> 
		  <input type='hidden' name='type' value='$type' />
		  <input type='hidden' name='signature' value='$signature' />
		  <input type='hidden' name='language' value='$language' />
 
		";		
		
        $this->render('LiqPay', array(
            'xml_encoded' => $xml
        ));
    }

    /**
     * Create configure form
     *
     * @return string
     */
    public function getAdminForm() {
        $data = $this->loadSettings();

        $form = '
            
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Public key', 'main') . ':</label>
                <div class="controls">
                 <input type="text" name="LiqPay[merchant_id]" value="' . $data['merchant_id'] . '"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Private key', 'main') . ':</label>
                <div class="controls">
                 <input type="text" name="LiqPay[merchant_sig]" value="' . $data['merchant_sig'] . '" />
                </div>
            </div>
     
        ';

        return $form;
    }

    /**
     * Save settings
     *
     * @return bool|string
     */
    public function saveSettings(SPaymentMethods $paymentMethod) {
        $saveKey = $paymentMethod->getId() . '_LiqPayData';
        ShopCore::app()->SSettings->set($saveKey, serialize($_POST['LiqPay']));

        return true;
    }

    /**
     * Load Robokassa settings
     *
     * @return array
     */
    protected function loadSettings() {
        $settingsKey = $this->paymentMethod->getId() . '_LiqPayData';
        $data = unserialize(ShopCore::app()->SSettings->$settingsKey);
        if ($data === false)
            $data = array();
        return array_map('encode', $data);
    }

}