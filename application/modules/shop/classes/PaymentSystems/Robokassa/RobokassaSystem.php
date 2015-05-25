<?php

/**
 * Robokassa payment module
 *
 * author: dev
 * more info at: http://www.robokassa.ru/HowTo.aspx
 */
class RobokassaSystem extends BasePaymentProcessor {

    protected $settigns = null;
    public $template_vars = array();

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
        $mrh_pass2 = $data['password2'];
        $shp_order_key = $this->order->getKey();
        $shp_payment_id = $this->paymentMethod->getId();

        $out_summ = $_REQUEST["OutSum"];
        $inv_id = $_REQUEST["InvId"];
        $crc = strtoupper($_REQUEST["SignatureValue"]);
        $my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id"));

        // Check sum
        if ($out_summ != \Currency\Currency::create()->convert($this->order->getTotalPrice(), $this->paymentMethod->getCurrencyId()))
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

        return true;
    }

    /**
     * Create payment form
     *
     * @return string Generated form
     */
    public function getForm() {

        $inv_desc = "Оплата заказа номер " . $this->order->getId();


        $data = $this->loadSettings();
//
//        // Оплата заданной суммы с выбором валюты на сайте ROBOKASSA
//        // регистрационная информация (логин, пароль #1)
        $mrh_login = $data['login'];
        $mrh_pass1 = $data['password1'];
        $shp_order_key = $this->order->getKey();
        $shp_payment_id = $this->paymentMethod->getId();
//
//        // номер заказа
        $inv_id = $this->order->getId();
//
        // ціна товарів
        $productsPrice = $this->order->getTotalPrice();
        // ціна доставки
        $deliveryPrice = $this->order->getDeliveryPrice();
        $out_summ = \Currency\Currency::create()->convert($deliveryPrice + $productsPrice, $this->paymentMethod->getCurrencyId());
//        // предлагаемая валюта платежа
        $in_curr = "PCR";
//
//        // язык
        $culture = "ru";
//
//        // формирование подписи
        $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id");

        $this->render('Robokassa', array(
            'mrh_login' => $mrh_login,
            'out_summ' => $out_summ,
            'inv_id' => $inv_id,
            'inv_desc' => $inv_desc,
            'crc' => $crc,
            'shp_order_key' => $shp_order_key,
            'shp_payment_id' => $shp_payment_id,
            'in_curr' => $in_curr,
            'culture' => $culture
        ));
    }

    public function add_array($arr) {

        if (count($arr) > 0) {

            $this->template_vars = array_merge($this->template_vars, $arr);

            return TRUE;
        }
        return FALSE;
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
                <label class="control-label" for="inputRecCount">' . lang('Login', 'main') . ':</label>
                <div class="controls">
                  <input type="text" name="robo[login]" value="' . $data['login'] . '"  />
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Password', 'main') . ' 1:</label>
                <div class="controls">
                 <input type="text" name="robo[password1]" value="' . $data['password1'] . '"  />
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Password') . ' 2:</label>
                <div class="controls">
                  <input type="text" name="robo[password2]" value="' . $data['password2'] . '"/>
                </div>
            </div>
            
            
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Merchant settings', 'main') . ':</label>
                <div class="controls">
                Result URL: ' . shop_url('order/view/') . '<br/>
                Success URL: ' . shop_url('order/view/') . '<br/>
                Fail URL: ' . shop_url('order/view/') . '<br/><br/>
                    <span class="help-block">' . lang('The method of sending data for all requests: GET', 'main') . '.</span>
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
        $saveKey = $paymentMethod->getId() . '_RobokassaData';
        ShopCore::app()->SSettings->set($saveKey, serialize($_POST['robo']));

        return true;
    }

    /**
     * Load Robokassa settings
     *
     * @return array
     */
    protected function loadSettings() {
        $settingsKey = $this->paymentMethod->getId() . '_RobokassaData';
        $data = unserialize(ShopCore::app()->SSettings->$settingsKey);
        if ($data === false)
            $data = array();
        return array_map('encode', $data);
    }

}