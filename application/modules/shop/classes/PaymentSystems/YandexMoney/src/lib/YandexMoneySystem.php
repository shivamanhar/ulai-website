<?php

/**
 * Robokassa payment module
 *
 * author: dev
 * more info at: http://www.robokassa.ru/HowTo.aspx
 */
class YandexMoneySystem extends BasePaymentProcessor {

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

				$model2 = \ShopsettingsQuery::create()->filterByName('%YandexMoneyData')->findOne();
				$result = $model2->getValue();
				$result = unserialize ($result);

				$client = $result['client'];
				$account = $result['account'];
				$secret = $result['secret'];
				$token = $result['token'];


        // Check sum
        if ($out_summ != \Currency\Currency::create()->convert($this->order->getTotalPrice() + $this->order->getDeliveryPrice(), $this->paymentMethod->getCurrencyId()))
            return ERROR_SUM;

        // Check sign
        if ($my_crc != $crc)
            return "bad sign $out_summ:$inv_id:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id";

        // Set order paid
        $this->setOrderPaid();



        return true;
    }

    /**
     * Create payment form
     *
     * @return string Generated form
     */
    public function getForm() {
        $data = $this->loadSettings();

        // Оплата заданной суммы с выбором валюты на сайте YandexMoney
        // регистрационная информация (логин, пароль #1)
        $YandexMoney = $data['account'];
        $merchant_sig = $data['merchant_sig'];
        $shp_order_key = $this->order->getKey();
        $shp_payment_id = $this->paymentMethod->getId();

        // номер заказа
        $inv_id = $this->order->getId();

        // описание заказа
        $inv_desc = "Оплата заказа номер " . $this->order->getId();

        $productsPrice = $this->order->getTotalPrice();
        // ціна доставки
        $deliveryPrice = $this->order->getDeliveryPrice();
        $out_summ = $deliveryPrice + $productsPrice;


        // предлагаемая валюта платежа
        $ISOCode = SCurrenciesQuery::create()->filterByIsDefault(true)->findOne()->getCode();


        // формирование подписи
        //$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id");
        // формирование подписи
		$crc = md5("$out_summ:$inv_id:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id");

		
        $this->render('YandexMoney', array(
            'YandexMoney' => $YandexMoney,
            'merchant_sig' => $merchant_sig,
            'shp_order_key' => $shp_order_key,
            'shp_payment_id' => $shp_payment_id,
            'inv_id' => $inv_id,
            'inv_desc' => $inv_desc,
			
            'out_summ' => $out_summ,
            'ISOCode' => $ISOCode,
            'crc' => $crc
        ));

        // форма оплаты товара
//echo '<iframe allowtransparency="true" src="https://money.yandex.ru/embed/small.xml?uid='.$YandexMoney.'&amp;button-text=01&amp;button-size=l&amp;button-color=orange&amp;targets='.$inv_desc.'&amp;default-sum='.$out_summ.'" frameborder="0" height="54" scrolling="no" width="auto"></iframe>';
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
                <label class="control-label" for="inputRecCount">' . lang('Recipient account', 'main') . ':</label>
                <div class="controls">
                 <input type="text" name="YandexMoney[account]" value="' . $data['account'] . '"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Merchant settings', 'main') . ':</label>
                <div class="controls">
                  Result URL: ' . shop_url('cart/view/?result=true&pm=' . $this->paymentMethod->getId()) . '<br/>
                Server URL: ' . shop_url('cart/view/?result=true&pm=' . $this->paymentMethod->getId()) . '<br/>
                <span class="help-block">' . lang('The method of sending data for all requests: GET', 'main') . '</span>
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
        $saveKey = $paymentMethod->getId() . '_YandexMoneyData';
        ShopCore::app()->SSettings->set($saveKey, serialize($_POST['YandexMoney']));

        return true;
    }

    /**
     * Load Robokassa settings
     *
     * @return array
     */
    protected function loadSettings() {
        $settingsKey = $this->paymentMethod->getId() . '_YandexMoneyData';
        $data = unserialize(ShopCore::app()->SSettings->$settingsKey);
        if ($data === false)
            $data = array();
        return array_map('encode', $data);
    }

}