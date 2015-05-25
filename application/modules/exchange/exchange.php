<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Exchange Class
 * exchange class handles 1c import/export
 * @package 1C-Exchange
 * @author ImageCMS <dev
 */
class Exchange extends \MY_Controller {

    /** array which contains 1c settings  */
    private $my_config = array();

    /** object instance of ci */
    private $ci;

    /** default directory for saving files from 1c */
    private $tempDir;

    /** contains default locale */
    private $locale;

    /** table which contains module settings if modules is installed */
    private $settings_table = 'components';
    private $allowed_image_extensions = array();
    private $login;
    private $password;
    private $prod = array();
    private $brand = array();

    /** Runtime variable */
    private $time = 0;

    public function __construct() {
        parent::__construct();

        $this->time = time();
        set_time_limit(0);

        $lang = new MY_Lang();
        $lang->load('exchange');

        $this->load->helper('translit');
        $this->load->helper('file');
        $this->load->helper('exchange');
        $this->load->config('exchange');

        /**
         *    define path to folder for saving files from 1c 
         */
        $this->tempDir = $this->config->item('tempDir');
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir);
        }

        $this->locale = MY_Controller::getCurrentLocale();    //getting current locale
        $this->my_config = $this->get1CSettings();

        if (!$this->my_config) {
            //default settings if module is not installed yet
            if (class_exists('ZipArchive')) {
                $this->my_config['zip'] = 'yes';
            } else {
                $this->my_config['zip'] = 'no';
            }
            $this->my_config['filesize'] = $this->config->item('filesize');
            $this->my_config['validIP'] = $this->config->item('validIP');
            $this->my_config['password'] = $this->config->item('password');
            $this->my_config['usepassword'] = $this->config->item('usepassword');
            $this->my_config['userstatuses'] = $this->config->item('userstatuses');
            $this->my_config['autoresize'] = $this->config->item('autoresize');
            $this->my_config['debug'] = $this->config->item('debug');
            $this->my_config['email'] = $this->config->item('email');
        }

        //        $this->db->truncate('shop_category');
        //        $this->db->truncate('shop_category_i18n');
        //
  //        $this->db->truncate('shop_brands');
        //        $this->db->truncate('shop_brands_i18n');
        //
  //        $this->db->truncate('shop_products');
        //        $this->db->truncate('shop_products_i18n');
        //        $this->db->truncate('shop_product_variants');
        //        $this->db->truncate('shop_product_variants_i18n');
        //        $this->db->truncate('shop_product_categories');
        //
  //        $this->db->truncate('shop_product_properties');
        //        $this->db->truncate('shop_product_properties_i18n');
        //        $this->db->truncate('shop_product_properties_categories');
        //        $this->db->truncate('shop_product_properties_data');
        //        $this->db->truncate('shop_product_properties_data_i18n');
        //        $this->db->truncate('shop_product_images');
        //
  //        $this->db->truncate('shop_orders');
        //        $this->db->truncate('shop_orders_products');

        if (isset($this->my_config['brand'])) {
            $this->brand = load_brand();
        }

        $this->allowed_image_extensions = array('jpg', 'jpeg', 'png', 'gif');

        //define first get command parameter
        $method = 'command_';

        $this->login = isset($_SERVER['PHP_AUTH_USER']) ? trim($_SERVER['PHP_AUTH_USER']) : NULL;
        $this->password = isset($_SERVER['PHP_AUTH_PW']) ? trim($_SERVER['PHP_AUTH_PW']) : NULL;

        //saving get requests to log file
        if ($_GET) {
            $string = '';
            foreach ($_GET as $key => $value) {
                $string .= date('c') . " GET - " . $key . ": " . $value . "\n";
            }
            write_file($this->tempDir . "log.txt", $string, 'ab');
        }

        //preparing method and mode name from $_GET variables
        if (isset($_GET['type']) && isset($_GET['mode'])) {
            $method .= strtolower($_GET['type']) . '_' . strtolower($_GET['mode']);
        }

        //run method if exist
        if (method_exists($this, $method)) {
            $this->$method();
        }
    }

    public function __destruct() {
        $this->time = time() - $this->time;
        foreach ($this->input->get() as $get) {
            write_file($this->tempDir . '/time.txt', date('Y-m-d h:i:s') . ': ' . $get . PHP_EOL, FOPEN_WRITE_CREATE);
        }
        write_file($this->tempDir . '/time.txt', date('Y-m-d h:i:s') . ': time - ' . $this->time . PHP_EOL, FOPEN_WRITE_CREATE);
        write_file($this->tempDir . '/time.txt', "-----------------------------------------" . PHP_EOL, FOPEN_WRITE_CREATE);
    }

    /**
     * Use this function to make backup before import starts
     */
    protected function makeDBBackup() {
        if (is_really_writable(BACKUPFOLDER)) {
            \libraries\Backup::create()->createBackup("zip", "exchange");
        } else {
            $this->error_log(langf('Can not create a database snapshot, check the folder {0} on writing possibility', 'exchange', array(BACKUPFOLDER)));
        }
    }

    /**
     * get 1c settings from modules table
     * @return boolean
     */
    private function get1CSettings() {
        $config = $this->db
                ->where('identif', 'exchange')
                ->get('components')
                ->row_array();
        if (empty($config)) {
            return false;
        } else {
            return unserialize($config['settings']);
        }
    }

    /**
     * module install function
     */
    function _install() {
        $this->load->dbforge();
        ($this->dx_auth->is_admin()) OR exit;
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'external_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'property_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'value' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE,
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('mod_exchange');

        $for_insert = serialize($this->my_config);
        $this->db
                ->where('identif', 'exchange')
                ->update($this->settings_table, array(
                    'settings' => $for_insert,
                    'enabled' => 1,
        ));
    }

    public function _deinstall() {
        $this->load->dbforge();
        ($this->dx_auth->is_admin()) OR exit;
        $this->dbforge->drop_table('mod_exchange');
    }

    /**
     * Error loging methods
     * @param string $error
     * @param string $send_email
     */
    function error_log($error, $send_email = FALSE) {
        $intIp = $_SERVER ["REMOTE_ADDR"];
        if (isset($_SERVER ["HTTP_X_FORWARDED_FOR"])) {
            if (isset($_SERVER ["HTTP_X_REAL_IP"])) {
                $intIp = $_SERVER ["HTTP_X_REAL_IP"];
            } else {
                $intIp = $_SERVER ["HTTP_X_FORWARDED_FOR"];
            }
        }

        if ($this->my_config['debug']) {
            write_file($this->tempDir . "error_log.txt", $intIp . ' - ' . date('c') . ' - ' . $error . PHP_EOL, 'ab');
        }

        if ($send_email) {
            $this->load->library('email');

            $this->email->from("noreplay@{$_SERVER['HTTP_HOST']}");
            $this->email->to($this->my_config['email']);

            $this->email->subject('1C exchange');
            $this->email->message($intIp . ' - ' . date('c') . ' - ' . $error . PHP_EOL);

            $this->email->send();
        }
    }

    function __autoload() {
        return;
    }

    /**
     * checking password from $_GET['password'] if use_password option in settings is "On"
     */
    private function check_password() {
        if (($this->my_config['login'] == $this->login) && ($this->my_config['password'] == $this->password)) {
            $this->checkauth();
        } else {
            echo "failure. wrong password";
            $this->error_log(lang('Wrong password', 'exchange'), TRUE);
        }
    }

    /**
     * return to 1c session id and success status
     * to initialize import start
     */
    private function command_catalog_checkauth() {
        if ($this->my_config['usepassword'] == 'on') {
            $this->check_password();
        } else {
            $this->checkauth();
        }
        exit();
    }

    /**
     * preparing to import
     * writing session id to txt file in md5
     * deleting old import files
     */
    private function checkauth() {
        echo "success\n";
        echo session_name() . "\n";
        echo session_id() . "\n";
        $string = md5(session_id());
        write_file($this->tempDir . "session.txt", $string, 'w');
    }

    /**
     * checking if current session id matches session id in txt files
     * @return boolean
     */
    private function check_perm() {

        if ($this->my_config['debug']) {
            return true;
        }

        $string = read_file($this->tempDir . 'session.txt');
        if (md5(session_id()) == $string) {
            return true;
        } else {
            $this->error_log(lang('Security Error!!!', 'exchange'), TRUE);
            die(lang('Security Error!!!', 'exchange'));
        }
    }

    /**
     * returns exchange settings to 1c
     * @zip no
     * @file_limit in bytes
     */
    private function command_catalog_init() {
        if ($this->check_perm() === true) {

            echo "zip=" . $this->my_config['zip'] . "\n";
            echo "file_limit=" . $this->my_config['filesize'] . "\n";
        }
        exit();
    }

    /**
     * saves exchange files to tempDir
     * xml files will be saved to tempDir/
     * images wil be saved  to tempDir/images as jpg files
     */
    private function command_catalog_file() {
        if ($this->check_perm() === true) {

            $file_info = pathinfo($this->input->get('filename'));
            $file_extension = $file_info['extension'];
            $path = $file_info['dirname'];

            if ($file_extension != 'zip' && $file_extension != 'xml' && in_array($file_extension, $this->allowed_image_extensions)) {
//saving images to cmlTemp/images folder
                @mkdir($this->tempDir . $path, 0777, TRUE);
                if (write_file($this->tempDir . $this->input->get('filename'), file_get_contents('php://input'), 'w+')) {
                    echo "success";
                }
            } else {
//saving xml files to cmlTemp
                if (write_file($this->tempDir . $this->input->get('filename'), file_get_contents('php://input'), 'w+')) {
                    echo "success";
                }
            }
//extracting filles
            if ($file_extension == 'zip' && class_exists('ZipArchive')) {
                $zip = new ZipArchive();
                $zip->open($this->tempDir . $this->input->get('filename'));
                if ($res > 0 && $res != TRUE) {
                    switch ($res) {
                        case ZipArchive::ER_NOZIP :
                            $this->error_log('Not a zip archive.');
                            break;
                        case ZipArchive::ER_INCONS :
                            $this->error_log('Zip archive inconsistent.');
                            break;
                        case ZipArchive::ER_CRC :
                            $this->error_log('checksum failed');
                            break;
                        case ZipArchive::ER_EXISTS :
                            $this->error_log('File already exists.');
                            break;
                        case ZipArchive::ER_INVAL :
                            $this->error_log('Invalid argument.');
                            break;
                        case ZipArchive::ER_MEMORY :
                            $this->error_log('Malloc failure.');
                            break;
                        case ZipArchive::ER_NOENT :
                            $this->error_log('No such file.');
                            break;
                        case ZipArchive::ER_OPEN :
                            $this->error_log("Can't open file.");
                            break;
                        case ZipArchive::ER_READ :
                            $this->error_log("Read error.");
                            break;
                        case ZipArchive::ER_SEEK :
                            $this->error_log("Seek error.");
                            break;
                    }
                    echo 'failure';
                    exit();
                } else {
                    $zip->extractTo($this->tempDir);
                }
                $zip->close();
            }
        }
        exit();
    }

    /**
     * loading xml file to $this->xml variable
     * uses simple xml extension
     * @param type $file
     * @return boolean
     */
    private function _readXmlFile($file) {
        $path = $this->tempDir . $file;
        if (!file_exists($path) || !is_file($path)) {
            exit('Error opening file: ' . $path);
        }
        return simplexml_load_file($path);
    }

    private function command_catalog_import() {
        if ($this->check_perm() === true) {
            if ($this->my_config['backup']) {
                $this->makeDBBackup();
            }
// getting xml
            $xml = $this->_readXmlFile($_GET['filename']);

            try {
// IMPORT PROPERTIES

                if (isset($xml->Классификатор->Свойства)) {
                    $props = $xml->Классификатор->Свойства;
                    $propertiesData = isset($props->СвойствоНоменклатуры) ? $props->СвойствоНоменклатуры : $props->Свойство;
                    \exchange\classes\Properties::getInstance()
                            ->setBrandIdentif($this->my_config['brand'])
                            ->import($propertiesData);
                }

// IMPORT CATEGORIES
                if (isset($xml->Классификатор->Группы)) {
                    \exchange\classes\Categories::getInstance()->import($xml->Классификатор->Группы->Группа);
                }

// IMPORT PRODUCTS
                if (isset($xml->Каталог->Товары)) {
                    if ($this->my_config['autoresize'] == 'on') {
                        $res = TRUE;
                    } else {
                        $res = FALSE;
                    }

                    \exchange\classes\Products::getInstance()
                            ->setTempDir($this->tempDir)
                            ->setResize($res)
                            ->import($xml->Каталог->Товары->Товар);
                }

// IMPORT PRICES (IF THERE ARE ANY)
                if (isset($xml->ПакетПредложений->Предложения)) {
                    \exchange\classes\Prices::getInstance()
                            ->import($xml->ПакетПредложений->Предложения->Предложение);
                }

                /**
                 * send notifications if changes products quantity
                 */
                Notificator::run();
            } catch (Exception $e) {
                $this->error_log(lang('Import error', 'exchange') . ': ' . $e->getMessage() . $e->getFile() . $e->getLine());
                echo $e->getMessage() . $e->getFile() . $e->getLine();
                echo "failure";
                exit;
            }
            exit('success');
        }
    }

    /**
     * checkauth for orders import
     */
    private function command_sale_checkauth() {
        if ($this->my_config['usepassword'] == 'on') {
            $this->check_password();
        } else {
            $this->checkauth();
        }
        exit();
    }

    /**
     * returns exchange settings to 1c
     * @zip no
     * @file_limit in bytes
     */
    private function command_sale_init() {
        if ($this->check_perm() === true) {
            $this->command_catalog_init();
        }
        exit();
    }

    /**
     * saving xml files with orders from 1c
     * and runs orders import
     */
    private function command_sale_file() {
        if ($this->check_perm() === true) {
            $this->load->helper('file');
            if (write_file($this->tempDir . $_GET['filename'], file_get_contents('php://input'), 'a+'))
                echo "success";
            $this->command_sale_import();
        }
        exit();
    }

    /**
     * procced orders import
     * @return string
     */
    private function command_sale_import() {
        if ($this->check_perm() === true) {
            $this->xml = $this->_readXmlFile($_GET['filename']);
            if (!$this->xml)
                return "failure";
            foreach ($this->xml->Документ as $order) {
                $model = SOrdersQuery::create()->findOneById($order->Номер);
                if ($model) {
                    $model->setExternalId($order->Ид);
                    $usr = SUserProfileQuery::create()->findByUserExternalId($order->Контрагенты->Контрагент->Ид);
                    if (!$usr) {
                        $usr->setUserExternalId($order->Контрагенты->Контрагент->Ид);
                    }
                    $model->setTotalPrice($order->Сумма);
                    $model->setDateUpdated(date('U'));
                    foreach ($order->ЗначенияРеквизитов->ЗначениеРеквизита as $item) {
                        if ($item->Наименование == 'ПометкаУдаления') {
                            if ($item->Значение == true) {
                                $model->setStatus(1);
                            }
                        }
                        if ($item->Наименование . "" == 'Проведен') {
                            if ($item->Значение == true) {
                                $model->setStatus(10);
                            }
                        }
                        if ($item->Наименование . "" == 'Дата оплаты по 1С') {
                            if (strtotime($item->Значение)) {
                                if ($item->Значение . "" != "Т") {
                                    $model->setPaid(1);
                                    echo "success</br>";
                                }
                            }
                        }
                        /* if ($item->Наименование == 'Номер отгрузки по 1С') {
                          $model->setStatus(3);
                          } */
                    }
                    $model->save();
                } else {
                    echo "fail. order not found";
                }
            }
            if (!$this->my_config['debug']) {
                rename($this->tempDir . $_GET['filename'], $this->tempDir . "success_" . $_GET['filename']);
            }
        }
        exit();
    }

    /**
     * runs when orders from site succesfully uploaded to 1c server
     * and sets some status for imported orders "waiting" for example
     */
    private function command_sale_success() {
        if ($this->check_perm() === true) {
            $model = SOrdersQuery::create()->findByStatus($this->my_config['userstatuses']);
            foreach ($model as $order) {
                $order->SetStatus($this->my_config['userstatuses_after']);
                $order->save();
            }
        }
        exit();
    }

    /**
     * creating xml document with orders to make possible for 1c to grab it
     */
    private function command_sale_query() {
        if ($this->check_perm() === true) {
            $model = SOrdersQuery::create()->findByStatus($this->my_config['userstatuses']);
            header('content-type: text/xml; charset=utf-8');
            $xml_order .= "<?xml version='1.0' encoding='UTF-8'?>" . "\n" .
                    "<КоммерческаяИнформация ВерсияСхемы='2.03' ДатаФормирования='" . date('Y-m-d') . "'>" . "\n";
            foreach ($model as $order) {
                if ($order->user_id != Null) {
                    $user_prof = SUserProfileQuery::create()->findById($order->user_id);
                    if ($user_prof->user_external_id != '')
                        $ext_id = $row['external_id'];
                }
                $xml_order.="<Документ>\n" .
                        "<Ид>" . $order->Id . "</Ид>\n" .
                        "<Номер>" . $order->Id . "</Номер>\n" .
                        "<Дата>" . date('Y-m-d', $order->date_created) . "</Дата>\n" .
                        "<ХозОперация>Заказ товара</ХозОперация>\n" .
                        "<Роль>Продавец</Роль>\n" .
                        "<Валюта>" . \Currency\Currency::create()->main->getCode() . "</Валюта>\n" .
                        "<Курс>1</Курс>\n" .
                        "<Сумма>" . $order->totalprice . "</Сумма>\n" .
                        "<Контрагенты>\n" .
                        "<Контрагент>\n" .
                        "<Ид>" . $ext_id . "</Ид>\n" .
                        "<Наименование>" . $order->UserFullName . "</Наименование>\n" .
                        "<Роль>Покупатель</Роль>" .
                        "<ПолноеНаименование>" . $order->UserFullName . "</ПолноеНаименование>\n" .
                        "<Фамилия>" . $order->UserFullName . "</Фамилия>" .
                        "<Имя>" . $order->UserFullName . "</Имя>" .
                        "<АдресРегистрации>" .
                        "<Представление>" . $order->user_deliver_to . "</Представление>" .
                        "<Комментарий></Комментарий>"
                        . "</АдресРегистрации>" .
                        "<Контакты>" .
                        "<Контакт>" .
                        "<Тип>ТелефонРабочий</Тип>" .
                        "<Значение>" . $order->user_phone . "</Значение>" .
                        "<Комментарий></Комментарий>" .
                        "</Контакт>" .
                        "<Контакт>" .
                        "<Тип>Почта</Тип>" .
                        "<Значение>" . $order->user_email . "</Значение>" .
                        "<Комментарий>Пользовательская почта</Комментарий>" .
                        "</Контакт>" .
                        "</Контакты>" .
                        "</Контрагент>\n" .
                        "</Контрагенты>\n" .
                        "<Время>" . date('G:i:s', $order->date_created) . "</Время>\n" .
                        "<Комментарий>" . $order->user_comment . "</Комментарий>\n" .
                        "<Товары>\n";
                $ordered_products = SOrderProductsQuery::create()
                        ->joinSProducts()
                        ->findByOrderId($order->Id);
                if ($order->deliverymethod != null) {
                    $xml_order .= "<Товар>\n" .
                            "<Ид>ORDER_DELIVERY</Ид>\n" .
                            "<Наименование>Доставка заказа</Наименование>\n" .
                            '<БазоваяЕдиница Код="796" НаименованиеПолное="Штука" МеждународноеСокращение="PCE">шт</БазоваяЕдиница>' . "\n" .
                            "<ЦенаЗаЕдиницу>" . $order->deliveryprice . "</ЦенаЗаЕдиницу>\n" .
                            "<Количество>1</Количество>\n" .
                            "<Сумма>" . $order->deliveryprice . "</Сумма>\n" .
                            "<ЗначенияРеквизитов>\n" .
                            "<ЗначениеРеквизита>\n" .
                            "<Наименование>ВидНоменклатуры</Наименование>\n" .
                            "<Значение>Услуга</Значение>\n" .
                            "</ЗначениеРеквизита>\n" .
                            "<ЗначениеРеквизита>\n" .
                            "<Наименование>ТипНоменклатуры</Наименование>\n" .
                            "<Значение>Услуга</Значение>\n" .
                            "</ЗначениеРеквизита>\n" .
                            "</ЗначенияРеквизитов>\n" .
                            "</Товар>\n";
                }
                /* @var $product SOrderProducts */
                foreach ($ordered_products as $product) {
                    $category = get_product_category($product->product_id);

                    $xml_order .= "<Товар>\n" .
                            "<Ид>" . $product->getSProducts()->getExternalId() . "</Ид>\n" .
                            "<ИдКаталога>{$category['external_id']}</ИдКаталога>\n" .
                            "<Наименование>" . ShopCore::encode($product->product_name) . "</Наименование>\n" .
                            '<БазоваяЕдиница Код="796" НаименованиеПолное="Штука" МеждународноеСокращение="PCE">шт</БазоваяЕдиница>' . "\n" .
                            "<ЦенаЗаЕдиницу>" . $product->price . "</ЦенаЗаЕдиницу>\n" .
                            "<Количество>$product->quantity</Количество>\n" .
                            "<Сумма>" . ($product->price) * ($product->quantity) . "</Сумма>\n" .
                            "<ЗначенияРеквизитов>\n" .
                            "<ЗначениеРеквизита>\n" .
                            "<Наименование>ВидНоменклатуры</Наименование>\n" .
                            "<Значение>Товар</Значение>\n" .
                            "</ЗначениеРеквизита>\n" .
                            "<ЗначениеРеквизита>\n" .
                            "<Наименование>ТипНоменклатуры</Наименование>\n" .
                            "<Значение>Товар</Значение>\n" .
                            "</ЗначениеРеквизита>\n" .
                            "</ЗначенияРеквизитов>\n" .
                            "</Товар>\n";
                }
                $xml_order .= "</Товары>\n";
                if ($order->paid == 0) {
                    $paid_status = 'false';
                } else {
                    $paid_status = 'true';
                }
                $status = SOrders::getStatusName('Id', $order->getStatus());
                $xml_order .= "<ЗначенияРеквизитов>\n" .
                        "<ЗначениеРеквизита>\n" .
                        "<Наименование>Метод оплаты</Наименование>\n" .
                        "<Значение>" . $order->getpaymentMethodName() . "</Значение>\n" .
                        "</ЗначениеРеквизита>\n" .
                        "<ЗначениеРеквизита>\n" .
                        "<Наименование>Заказ оплачен</Наименование>\n" .
                        "<Значение>" . $paid_status . "</Значение>\n" .
                        "</ЗначениеРеквизита>\n" .
                        "<ЗначениеРеквизита>\n" .
                        "<Наименование>Доставка разрешена</Наименование>\n" .
                        "<Значение>true</Значение>\n" .
                        "</ЗначениеРеквизита>\n" .
                        "<ЗначениеРеквизита>\n" .
                        "<Наименование>Отменен</Наименование>\n" .
                        "<Значение>false</Значение>\n" .
                        "</ЗначениеРеквизита>\n" .
                        "<ЗначениеРеквизита>\n" .
                        "<Наименование>Финальный статус</Наименование>\n" .
                        "<Значение>false</Значение>\n" .
                        "</ЗначениеРеквизита>\n" .
                        "<ЗначениеРеквизита>\n" .
                        "<Наименование>Статус заказа</Наименование>\n" .
                        "<Значение>" . $status . "</Значение>\n" .
                        "</ЗначениеРеквизита>\n" .
                        "<ЗначениеРеквизита>\n" .
                        "<Наименование>Дата изменения статуса</Наименование>\n" .
                        "<Значение>" . date('Y-m-d H:i:s', $order->date_updated) . "</Значение>\n" .
                        "</ЗначениеРеквизита>\n" .
                        "</ЗначенияРеквизитов>\n";
                $xml_order .= "</Документ>\n";
            }
            $xml_order .= "</КоммерческаяИнформация>";
//            $xml_order = iconv("UTF-8", "Windows-1251", $xml_order);
            echo $xml_order;
        }
        exit();
    }

}

/* End of file exchange.php */
