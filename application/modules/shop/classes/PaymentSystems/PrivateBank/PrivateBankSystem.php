<?php

/**
 * PrivatBank payment processor
 *
 * Additional info: https://api.privatbank.ua/p24api/
 * author: vasyl@siteimage.com.ua
 */
class PrivateBankSystem extends BasePaymentProcessor {

    public function __construct($order = null) {
        $this->order = ShopCore::app()->SPaymentSystems->getOrder();
        $lang = new MY_Lang();
        $lang->load('main');
        if ($order != null)
            $this->order = $order;
    }

    /**
     * Process payment
     */
    public function processPayment() {

        if (!isset($_POST['payment']) || !isset($_POST['signature'])) {
            die('YES');
        }

        $payment = $_POST['payment'];

        $merId = $this->paymentMethod->getId() . '_PB_MERCHANT_ID';
        $merId = encode(ShopCore::app()->SSettings->$merId);

        $merPassword = $this->paymentMethod->getId() . '_PB_MERCHANT_PASSWORD';
        $merPassword = encode(ShopCore::app()->SSettings->$merPassword);

        $apiUrl = $this->paymentMethod->getId() . '_PB_API_URL';
        $apiUrl = encode(ShopCore::app()->SSettings->$merId);

        // Create and check signature.
        $signature = sha1(md5($payment . $merPassword));
        // If OK make order paid.
        if ($signature != $_POST['signature']) {
            return $this->returnAnswer(ERROR_WRONG_LMI_HASH);
        }

        $values = explode('&', $payment);

        $payment = array();

        foreach ($values as $value) {
            $arr = explode('=', $value);
            $payment[$arr[0]] = $arr[1];
        }

        $orderId = explode('_', $payment['order']);
        $orderId = $orderId[0];

        switch ($payment['state']) {
            case 'ok':
                if ($orderId == $this->order->getId() && $payment['amt'] == $this->order->getTotalPrice()) {


                    if ($this->order->getUserId()) {
                        $user = SUserProfileQuery::create()->filterById($this->order->getUserId())->findone();

                        if ($user) {
                            $user->setAmout($user->getAmout() + $this->order->getTotalPrice());
                            $user->save();
                        }
                    }
                    exit();
                    $this->setOrderPaid();

                    return true;
                }
                break;
            case 'failure':
                if ($orderId == $this->order->getId() && $payment['amt'] == $this->order->getTotalPrice()) {
//                    $this->setOrderFailure();
                    return true;
                }
                break;
            case 'test':
                if ($orderId == $this->order->getId() && $payment['amt'] == $this->order->getTotalPrice()) {

                    if ($this->order->getUserId()) {
                        $user = SUserProfileQuery::create()->filterById($this->order->getUserId())->findone();

                        if ($user) {
                            $user->setAmout($user->getAmout() + $this->order->getTotalPrice());
                            $user->save();
                        }
                    }

                    $this->setOrderPaid();
                }
                break;
        }

        return false;
    }

    protected function returnAnswer($text) {
        if (isset($_GET['result']) && $_GET['result'] == 'true') {
            die($text);
        } else {
            return $text;
        }
    }

    /**
     * Create payment form
     *
     * @return string Generated form
     */
    public function getForm($order = null) {
        $apiurl = $this->paymentMethod->getId() . '_PB_API_URL';
        $merid = $this->paymentMethod->getId() . '_PB_MERCHANT_ID';

        $productsPrice = $this->order->getTotalPrice();
        // ціна доставки
        $deliveryPrice = $this->order->getDeliveryPrice();
        $out_summ = \Currency\Currency::create()->convert($deliveryPrice + $productsPrice, $this->paymentMethod->getCurrencyId());

        $replace = array(
            //сумма
            'PAYMENT_AMOUNT' => $out_summ,
            //валюта (UAH / USD / EUR)
            'CURRENCY' => \Currency\Currency::create()->getMainCurrency()->code,
            //ID мерчанта
            'MERCHANT_ID' => encode(ShopCore::app()->SSettings->$merid),
            //уникальный код операции
            'PAYMENT_NO' => $this->order->getId() . '_' . time(),
            //назначение платежа
            'PAYMENT_DESC' => 'Оплата заказа номер ' . $this->order->getId() . '.',
            //дополнительные данные (код товара, и т.п.) /можно оставить пустым
            'ADD_PAYMENT_DESC' => '',
            //страница, принимающая клиента после оплаты
            'SUCCESS_URL' => shop_url('order/view/' . $this->order->getKey()),
            //страница, принимающая ответ API о результате платежа
            'RESULT_URL' => shop_url('order/view/' . $this->order->getKey() . '/?result=true&amp;pm=' . $this->paymentMethod->getId()),
        );
        $this->render('PrivateBank', $replace);
    }

    /**
     * Create configure form
     *
     * @return string
     */
    public function getAdminForm() {
        $merId = $this->paymentMethod->getId() . '_PB_MERCHANT_ID';
        $merPassword = $this->paymentMethod->getId() . '_PB_MERCHANT_PASSWORD';
        $apiUrl = $this->paymentMethod->getId() . '_PB_API_URL';

        $form = '
            <div class="control-group">
                <label class="control-label">' . lang('Merchant id', 'main') . ': <span class="required">*</span></label>
                <div class="controls">
                    <input type="text" name="PB_MERCHANT_ID" value="' . encode(ShopCore::app()->SSettings->$merId) . '" class="textbox_long" />
                    <!--span class="help-block">' . lang('Trick seller to which the customer has to make a payment. Format - letter and 12 digits.', 'main') . '</span-->
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">' . lang('Merchant password', 'main') . ': <span class="required">*</span></label>
                <div class="controls">
                    <input type="text" name="PB_MERCHANT_PASSWORD" value="' . encode(ShopCore::app()->SSettings->$merPassword) . '" class="textbox_long" />
                    <!--span class="help-block">' . lang('Trick seller to which the customer has to make a payment. Format - letter and 12 digits.', 'main') . '</span-->
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">API URL: <span class="required">*</span></label>
                <div class="controls">
                    <input type="text" name="PB_API_URL" value="' . encode(ShopCore::app()->SSettings->$apiUrl) . '" class="textbox_long" />
                    <!--span class="help-block">' . lang('Trick seller to which the customer has to make a payment. Format - letter and 12 digits.', 'main') . '</span-->
                </div>
            </div>';

        return $form;
    }

    /**
     * Save settings
     *
     * @return bool|string
     */
    public function saveSettings(SPaymentMethods $paymentMethod) {
        $ci = & get_instance();
        $ci->load->library('Form_validation');

        $ci->form_validation->set_rules('PB_MERCHANT_ID', 'ID Мерчанта', 'trim|required');
        $ci->form_validation->set_rules('PB_MERCHANT_PASSWORD', 'Пароль Мерчанта', 'trim|required');
//        $ci->form_validation->set_rules('PB_API_URL', 'API URL', 'trim|required');

        if ($ci->form_validation->run() == FALSE)
            return validation_errors();
        else {
            // Save settings
            ShopCore::app()->SSettings->set($paymentMethod->getId() . '_PB_MERCHANT_ID', $_POST['PB_MERCHANT_ID']);
            ShopCore::app()->SSettings->set($paymentMethod->getId() . '_PB_MERCHANT_PASSWORD', $_POST['PB_MERCHANT_PASSWORD']);
            ShopCore::app()->SSettings->set($paymentMethod->getId() . '_PB_API_URL', $_POST['PB_API_URL']);
            return true;
        }
    }

}
