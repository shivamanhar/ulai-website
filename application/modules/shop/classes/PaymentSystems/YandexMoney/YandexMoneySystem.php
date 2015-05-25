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

        $data = $this->loadSettings();
        $notification_secret = $data['secret_notif'];
        $shp_order_key = $this->order->getKey();
        $shp_payment_id = $this->paymentMethod->getId();

		$str=$_POST['notification_type'] . '&' .
				$_POST['operation_id'] . '&' .
				$_POST['amount'] . '&' .
				$_POST['currency'] . '&' .
				$_POST['datetime'] . '&' .
				$_POST['sender'] . '&' .
				$_POST['codepro'] . '&' .
				$notification_secret . '&' .				
				$_POST['label'];


		if(sha1($str) != $_POST['sha1_hash']){
			return ERROR;
		}

        // Check sum
        //if ($_POST['withdraw_amount'] != \Currency\Currency::create()->convert($this->order->getTotalPrice() + $this->order->getDeliveryPrice(), $this->paymentMethod->getCurrencyId()))
        //    return ERROR_SUM;
 	
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
        $YandexMoney = $data['client'];		
        $merchant_sig = $data['secret'];
        $merchant_sig = $data['token'];		
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
                <div class="controls">
				<span class="help-block">' . lang('Links to create application:', 'main') . '</span>
				<span class="help-block">' . lang('https://sp-money.yandex.ru/myservices/new.xml', 'main') . '</span>	
				<span class="help-block">' . lang('https://sp-money.yandex.ru/myservices/online.xml', 'main') . '</span>				
                <span class="help-block">' . lang('Redirect url, HTTP:', 'main') . '</span>
                <span class="help-block">
                 ' . shop_url('order/view?result=true&pm=' . $this->paymentMethod->getId()) . '
                </span>
            </div>				
            </div>	
			<div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Client', 'main') . ':</label>
                <div class="controls">
                 <input type="text" name="YandexMoney[client]" value="' . $data['client'] . '"/>
                </div>
            </div>		
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Client_ID', 'main') . ':</label>
                <div class="controls">
                 <input type="text" name="YandexMoney[account]" value="' . $data['account'] . '"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Notification_secret', 'main') . ':</label>
                <div class="controls">
                 <input type="text" name="YandexMoney[secret_notif]" value="' . $data['secret_notif'] . '"/>
                </div>
            </div>			
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('OAuth2 client_secret', 'main') . ':</label>
                <div class="controls">
                 <input type="text" name="YandexMoney[secret]" value="' . $data['secret'] . '"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputRecCount"></label>
                <div class="controls">
                 <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#paymentmethodsUpdate" data-action="edit" data-submit=""><i class="icon-ok icon-white"></i> ' . lang('Get link for Received token ', 'main') . '</button>			 
                </div>			
			 </div> 			
            <div class="control-group">
			    <div class="controls">
				<span class="help-block">' . lang('Follow the link to get Received token:', 'main') . '</span>
				<span class="help-block">https://sp-money.yandex.ru/oauth/authorize?client_id='.  $data['account'] . '&response_type=code&scope=account-info+operation-history+operation-details&redirect_uri='. str_replace('/', '%2F', str_replace('://','%3A%2F%2F', site_url())) . 'shop%2Forder%2Fview%2F</span>				
				</div> 
			 </div>    
			 
			 <div class="control-group">               
                <label class="control-label" for="inputRecCount">' . lang('Received token', 'main') . ':</label>
                <div class="controls">
                 <input type="text" name="YandexMoney[token]" value="' . $data['token'] . '"/>
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