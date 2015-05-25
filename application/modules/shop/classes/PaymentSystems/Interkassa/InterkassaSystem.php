<?php

/**
 * Robokassa payment module
 *
 * author: dev
 * more info at: http://www.robokassa.ru/HowTo.aspx
 */
class InterkassaSystem extends BasePaymentProcessor {

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
        $InterkassaKey = $data['QiWiTime'];
        $shp_order_key = $this->order->getKey();
        $shp_payment_id = $this->paymentMethod->getId();

        $out_summ = $_POST['ik_am'];
        // Убираем лишние нули справа(баг системы-при смене валюты добавляются лишние нули).		
		if (strstr($out_summ,".")){
		$out_summ = rtrim($out_summ, '0');
		$out_summ = rtrim($out_summ, '.');}
		
        $inv_id = $_POST['ik_pm_no'];
        $crc = strtoupper($_POST['ik_x_crc']);

        $my_crc = strtoupper(md5("$out_summ:$inv_id:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id:$InterkassaKey"));

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
        $data = $this->loadSettings();

		
        // Оплата заданной суммы с выбором валюты на сайте Interkassa
        // регистрационная информация (логин, пароль #1)
        $InterkassaId = $data['QiWi'];
        $InterkassaKey = $data['QiWiTime'];
        $shp_order_key = $this->order->getKey();
        $shp_payment_id = $this->paymentMethod->getId();

        // номер заказа
        $inv_id = $this->order->getId();

        // описание заказа
        $inv_desc = "Оплата заказа номер " . $this->order->getId();

        // сумма заказа
        $productsPrice = $this->order->getTotalPrice();
		
        // цена доставки
        $deliveryPrice = $this->order->getDeliveryPrice();
        $out_summ = \Currency\Currency::create()->convert($deliveryPrice + $productsPrice, $this->paymentMethod->getCurrencyId());
        
		// Убираем лишние нули справа(баг системы-при смене валюты добавляются лишние нули).		
		if (strstr($out_summ,".")){
		$out_summ = rtrim($out_summ, '0');
		$out_summ = rtrim($out_summ, '.');}
        // предлагаемая валюта платежа
        $ISOCode = SCurrenciesQuery::create()->filterByIsDefault(true)->findOne()->getCode();
		if($ISOCode == 'RUR') $ISOCode = 'RUB';

        // формирование подписи
        $crc = md5("$out_summ:$inv_id:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id:$InterkassaKey");
		
	   // ссылка-ответ платежной системы		
		$successUrl = shop_url('order/view/'.$shp_order_key.'?result=true&amp;pm=' . $this->paymentMethod->getId() . '&amp;SignatureValue='.$crc. '&amp;OutSum='.$out_summ. '&amp;InvId='.$inv_id);

	   // язык интерфейса
		$lang = new MY_Lang();
		$language1 = $lang->getLangCode();
		
        $this->render('Interkassa', array(
            'InterkassaId' => $InterkassaId,
            'shp_order_key' => $shp_order_key,
            'shp_payment_id' => $shp_payment_id,
            'inv_id' => $inv_id,
            'inv_desc' => $inv_desc,
            'out_summ' => $out_summ,
            'ISOCode' => $ISOCode,
            'successUrl' => $successUrl,
            'language' => $language1[0],			
            'crc' => $crc
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
                <label class="control-label" for="inputRecCount">' . lang('Kassa number', 'main') . ':</label>
                <div class="controls">
                 <input type="text" name="QiWi[QiWi]" value="' . $data['QiWi'] . '" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Secret Key', 'main') . ':</label>
                <div class="controls">
                 <input type="text" name="QiWi[QiWiTime]" value="' . $data['QiWiTime'] . '" />
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
        $saveKey = $paymentMethod->getId() . '_InterkassaData';
        ShopCore::app()->SSettings->set($saveKey, serialize($_POST['QiWi']));

        return true;
    }

    /**
     * Load Robokassa settings
     *
     * @return array
     */
    protected function loadSettings() {
        $settingsKey = $this->paymentMethod->getId() . '_InterkassaData';
        $data = unserialize(ShopCore::app()->SSettings->$settingsKey);
        if ($data === false)
            $data = array();
        return array_map('encode', $data);
    }

}