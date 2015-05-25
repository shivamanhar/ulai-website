<?php

/**
 * author: dev
 */
class OschadBankInvoiceSystem extends BasePaymentProcessor {

    protected $settigns = null;
    protected $pdf = null;

    public function __construct() {
        $this->order = ShopCore::app()->SPaymentSystems->getOrder();
        $lang = new MY_Lang();
        $lang->load('main');
    }

    /**
     * Load pdf generating class and set main settings
     */
    protected function initPdfClass() {
        include(SHOP_DIR . 'classes/pdf/tcpdf.php');
        $this->pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $this->pdf->cms_cache_key = 'OschadBankInvoice';

        $this->pdf->setPDFVersion('1.6');
        $this->pdf->SetFont('dejavusanscondensed', '', 9);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);

        // Set text color to Black
        $this->pdf->SetTextColor(0, 0, 0);
    }

    /**
     * Process payment.
     * Display PDF document
     */
    public function processPayment() {
        $this->initPdfClass();

        // Create new page
        $this->pdf->AddPage();

        $this->drawMainData();
        $this->drawMainData('step2');

        // Draw bold lines
        $this->pdf->SetLineWidth(0.5);
        $this->pdf->Line(55, 5, 55, 137);
        // Hor. lines
        $this->pdf->SetLineWidth(0.4);
        $this->pdf->Line(5, 70, 205, 70);
        $this->pdf->Line(5, 71, 205, 71);

        // Write vertical text
        $this->pdf->SetFontSize(8);
        $this->pdf->setXY(5, 50);
        $this->pdf->StartTransform();
        $this->pdf->Rotate(90);
        $this->pdf->write(5, 'Заява на переказ готівки');
        $this->pdf->StopTransform();

        $this->pdf->setXY(5, 115);
        $this->pdf->StartTransform();
        $this->pdf->Rotate(90);
        $this->pdf->write(5, 'Квитанція');
        $this->pdf->StopTransform();

        // Shop generated pdf
        $this->pdf->Output('Oschad_Bank_invoice.pdf','D');
        exit();
    }

    /**
     * Draw invoice with user data.
     *
     * @param int $y
     * @return generated document
     */
    protected function drawMainData($y = 10) {
        $width = 150;
        $lineStep = 5;
        $x = 55;
        if ($y == 'step2') {
            $y = 77;
            $step2 = true;
        } else {
            $step2 = false;
        }


        // Draw vertical line from Sum to Home adress
        $this->pdf->Line($x + 35, $y, $x + 35, $y + 30);

        // Date of operation
        $this->drawTextB('Дата здійснення операції:', $x, $y, 150, 10);
        $this->pdf->Line($x, $y, $x + $width, $y);

        // Sum
        $this->drawTextB('Сумма:', $x, $y + $lineStep, 150, 10);
        $this->pdf->Line($x, $y + $lineStep, $x + $width, $y + $lineStep);

        // Platnik
        $this->drawTextB('Платник:', $x, $y + $lineStep * 2, 150, 10);
        $this->pdf->Line($x, $y + $lineStep * 2, $x + $width, $y + $lineStep * 2);

        // Home adress
        $this->drawTextB('Місце проживання:', $x, $y + $lineStep * 3 + 2, 150, 10);
        $this->pdf->Line($x + 35, $y + $lineStep * 3, $x + $width, $y + $lineStep * 3);
        $this->pdf->Line($x, $y + $lineStep * 4, $x + $width, $y + $lineStep * 4);

        // Recieve
        $this->drawTextB('Отримувач:', $x, $y + $lineStep * 5 + 2, 150, 10);
        $this->drawTextB($pdf, 'Назва:', $x + 35, $y + $lineStep * 5, 150, 10);
        $this->pdf->Line($x + 35, $y + $lineStep * 5, $x + $width, $y + $lineStep * 5);
        $this->pdf->Line($x, $y + $lineStep * 6, $x + $width, $y + $lineStep * 6);

        // Code, Number, MFO of Bank
        $this->pdf->Line($x + 50, $y + $lineStep * 6, $x + 50, $y + $lineStep * 8);
        $this->pdf->Line($x + 51, $y + $lineStep * 6, $x + 51, $y + $lineStep * 8);

        $this->pdf->Line($x + 120, $y + $lineStep * 6, $x + 120, $y + $lineStep * 8);
        $this->pdf->Line($x + 121, $y + $lineStep * 6, $x + 121, $y + $lineStep * 8);

        // Code
        $this->drawTextB('Код:', $x + 20, $y + $lineStep * 7, 150, 10);
        $this->drawTextB('Розрахунковий рахунок:', $x + 70, $y + $lineStep * 7, 150, 10);
        $this->drawTextB('МФО банку:', $x + 125, $y + $lineStep * 7, 150, 10);

        // Line under Code, MFO, etc
        $this->pdf->Line($x, $y + $lineStep * 7, $x + $width, $y + $lineStep * 7);
        $this->pdf->Line($x, $y + $lineStep * 8, $x + $width, $y + $lineStep * 8);

        // Line for numbers
        $n = 0;
        for ($i = 0; $i < 9; $i++) {
            $this->pdf->Line($x + $n, $y + $lineStep * 7, $x + $n, $y + $lineStep * 8);
            $n = $n + 5.5;
        }
        $n = 0;
        for ($i = 0; $i < 14; $i++) {
            $this->pdf->Line($x + $n + 50, $y + $lineStep * 7, $x + $n + 50, $y + $lineStep * 8);
            $n = $n + 5;
        }
        $n = 0;
        for ($i = 0; $i < 6; $i++) {
            $this->pdf->Line($x + $n + 120, $y + $lineStep * 7, $x + $n + 120, $y + $lineStep * 8);
            $n = $n + 5;
        }

        // Призначення платежу
        $this->drawTextB('Призначення платежу:', $x, $y + $lineStep * 9 + 2, 150, 10);
        $this->pdf->Line($x + 37, $y + $lineStep * 9, $x + $width, $y + $lineStep * 9);
        $this->pdf->Line($x, $y + $lineStep * 10, $x + $width, $y + $lineStep * 10);
        // Vertical line
        $this->pdf->Line($x + 37, $y + $lineStep * 8, $x + 37, $y + $lineStep * 10);

        // Buttom of invoice
        // Draw lines
        if ($step2 == false) {
            $this->drawTextB('Платник:', $x, $y + $lineStep * 11 + 2, 150, 10);
            $this->drawTextB('Контролер:', $x + 35, $y + $lineStep * 11 + 2, 150, 10);
            $this->drawTextB('Бухгалтер:', $x + 75, $y + $lineStep * 11 + 2, 150, 10);
            $this->drawTextB('Касир:', $x + 120, $y + $lineStep * 11 + 2, 150, 10);

            $this->pdf->Line($x + 35, $y + $lineStep * 10, $x + 35, $y + $lineStep * 12);
            $this->pdf->Line($x + 75, $y + $lineStep * 10, $x + 75, $y + $lineStep * 12);
            $this->pdf->Line($x + 120, $y + $lineStep * 10, $x + 120, $y + $lineStep * 12);
        } else {
            $this->drawTextB('Платник:', $x, $y + $lineStep * 11 + 2, 150, 10);
            $this->drawTextB('Контролер:', $x + 60, $y + $lineStep * 11 + 2, 150, 10);
            $this->drawTextB('Касир:', $x + 115, $y + $lineStep * 11 + 2, 150, 10);

            $this->pdf->Line($x + 60, $y + $lineStep * 10, $x + 60, $y + $lineStep * 12);
            $this->pdf->Line($x + 115, $y + $lineStep * 10, $x + 115, $y + $lineStep * 12);
        }

        // Left line
        $this->pdf->Line(205, $y + $lineStep * 4, 205, $y + $lineStep * 10);

        /** Draw user data * */
        //$this->pdf->SetFont('dejavusanscondensedi','',9);

        $settingsKey = $this->paymentMethod->getId() . '_OschadBankData';
        $userData = unserialize(ShopCore::app()->SSettings->$settingsKey);
        $userData['date'] = date('d.m.Y');
		// ціна доставки
        $deliveryPrice = $this->order->getDeliveryPrice();
        $userData['sum'] = \Currency\Currency::create()->convert($deliveryPrice + $this->order->getTotalPrice(), $this->paymentMethod->getCurrencyId());
        $userData['sum'] = str_replace('.', ',', $userData['sum']);
        $userData['sum'] .= ' ' . $userData['banknote'];
        $userData['purpose'] = 'Оплата замовлення номер ' . $this->order->getId();

        for ($i = 0; $i < strlen($userData['code']); $i++)
            $this->drawTextB($userData['code'][$i], $x + 1 + $i * 5.5, $y + $lineStep * 8, 150, 10);

        // Розрахунковий рахунок
        for ($i = 0; $i < strlen($userData['account']); $i++)
            $this->drawTextB($userData['account'][$i], $x + 51 + $i * 5, $y + $lineStep * 8, 150, 10);

        // МФО Банку
        $this->pdf->SetFontSize(9);
        for ($i = 0; $i < strlen($userData['mfo']); $i++) {
            $this->pdf->SetXY($x + 121 + ($i * 5), $y + $lineStep * 7);
            $this->pdf->Cell(5, 5, $userData['mfo'][$i]);
        }

        // Дата
        $this->drawTextB($userData['date'], $x + 45, $y, 150, 10);
        // Сумма
        $this->pdf->SetXY($x + 35, $y + 1);
        $this->pdf->MultiCell(115, 5, $userData['sum'], 0, 'C', 0, 1, '', '', true, null, true);
        // Отримувач
        $this->pdf->SetXY($x + 47, $y + $lineStep * 4 + 1);
        $this->pdf->MultiCell(103, 10, $userData['receiver'], 0, 'C', 0, 1, '', '', true, null, true);

        // Призначення платежу
        $this->pdf->SetXY($x + 38, $y + $lineStep * 8 + 1.5);
        $this->pdf->MultiCell(112, 9, $userData['purpose'], 0, 'C', 0, 1, '', '', true, null, true);

        $this->pdf->SetFont('dejavusanscondensed', '', 9);
        /** End draw user data * */
    }

    /**
     * Draw text
     *
     * @string  $text
     * @float  $x
     * @float  $y
     * @float  $width
     * @float  $height
     * @return void
     */
    protected function drawTextB($text, $x, $y, $width, $height) {
        $this->pdf->SetXY($x, $y - 5);
        $this->pdf->Write(5, $text);
    }

    /**
     * Create payment form
     *
     * @return string Generated form
     */
    public function getForm() {
        $form = '
        <form method="get" action="{URL}" target="_blank">
            <input type="hidden" value="{PM}"  name="pm">
            <input type="hidden" value="true"  name="getPdf">
            {PAY_BUTTON}
        </form>';

        $replace = array(
            '{PM}' => $this->paymentMethod->getId(),
            '{URL}' => shop_url('cart/view/' . $this->order->getKey()),
            '{PAY_BUTTON}' => $this->getPayButton(),
        );

        return str_replace(array_keys($replace), $replace, $form);
    }

    /**
     * Create configure form
     *
     * @return string
     */
    public function getAdminForm() {
        $settingsKey = $this->paymentMethod->getId() . '_OschadBankData';
        $data = unserialize(ShopCore::app()->SSettings->$settingsKey);
        if ($data == false)
            $data = array();
        $data = array_map('encode', $data);

        $form = '
           <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Recipient', 'main') . ':</label>
                <div class="controls">
                    <input type="text" name="bank[receiver]" value="' . $data['receiver'] . '" />
                </div>
        </div>
          
            <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Identifier code', 'main') . ':</label>
                <div class="controls number">
                    <input type="text" name="bank[code]" value="' . $data['code'] . '" maxlength="10" />
                        <span class="help-block">' . lang('Integer. The maximum length of 10 characters.', 'main') . '</span>
                </div>
        </div>
        
        <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Current account', 'main') . ':</label>
                <div class="controls number">
                     <input type="text" name="bank[account]" value="' . $data['account'] . '" " maxlength="14" />
                        <span class="help-block">' . lang('Integer. The maximum length of 14 characters.', 'main') . '</span>
                </div>
        </div>
     
        <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Bank MFI', 'main') . ':</label>
                <div class="controls number">
                     <input type="text" name="bank[mfo]" value="' . $data['mfo'] . '" maxlength="6" />
                        <span class="help-block">' . lang('Integer. The maximum length of 6 characters.', 'main') . '</span>
                </div>
        </div>

           
        <div class="control-group">
                <label class="control-label" for="inputRecCount">' . lang('Money sign', 'main') . ':</label>
                <div class="controls">
                      <input type="text" name="bank[banknote]" value="' . $data['banknote'] . '"  />
                        <span class="help-block">' . lang('For example: rub', 'main') . '</span>
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
        $ci = & get_instance();
        $ci->load->library('Form_validation');

        $ci->form_validation->set_rules('bank[code]', 'Ідентифікаційний код', 'max_length[10]');
        $ci->form_validation->set_rules('bank[account]', 'Розрахунковий рахунок', 'max_length[14]');
        $ci->form_validation->set_rules('bank[mfo]', 'МФО Банку', 'max_length[6]');

        if ($ci->form_validation->run() == FALSE)
            return validation_errors();

        $data = array(
            'receiver' => $_POST['bank']['receiver'],
            'code' => $_POST['bank']['code'],
            'account' => $_POST['bank']['account'],
            'mfo' => $_POST['bank']['mfo'],
            'banknote' => $_POST['bank']['banknote'],
        );


        $data = serialize($data);
        $saveKey = $paymentMethod->getId() . '_OschadBankData';
        ShopCore::app()->SSettings->set($saveKey, $data);

        // Clear font cache
        $ci->cache->delete('OschadBankInvoice');

        return true;
    }

}