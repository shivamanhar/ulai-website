<?php

/**
 * SSettings - Manager shop settings
 */
class SSettings {

    public $settings = array();
    public static $curentLocale = null;
    private $defaultLanguage = null;

    public function __construct() {
        $this->defaultLanguage = getDefaultLanguage();
        // Load and parse all settings
        $this->loadSettings();
        $CI = & get_instance();
        $CI->load->database();
    }

    /**
     * Load settings and store it in settings array
     *
     * @return void
     */
    public function loadSettings() {
        $model = ShopSettingsQuery::create();

        if (!is_null(self::$curentLocale)) {
            $model
                    ->where('ShopSettings.Locale = ?', self::$curentLocale)
                    ->_or()
                    ->where('ShopSettings.Locale = ?', '');
        } else {
            $model
                    ->where('ShopSettings.Locale = ?', $this->defaultLanguage['identif'])
                    ->_or()
                    ->Where('ShopSettings.Locale = ?', '');
        }

        $model = $model->find();

        if (sizeof($model) > 0) {
            foreach ($model as $row) {
                $this->settings[$row->getName()] = $row;
            }
        }
    }

    /**
     * Create new param and save it.
     *
     * @param  $name
     * @param  $value
     * @param  $create auto-create if not exists
     * @return void
     */
    public function set($name, $value, $create = true, $locale = 'ru') {
        if ($this->isTranslatable($name)) {
            $model = ShopSettingsQuery::create()
                    ->filterByName($name)
                    ->filterByLocale($locale)
                    ->findOne();

            if ($model == null)
                $model = new ShopSettings;

            $model->setName($name)
                    ->setValue($value)
                    ->setLocale($locale)
                    ->save();
        }
        elseif (!array_key_exists($name, $this->settings) && $create === true) {

            $model = new ShopSettings;

            $model->setName($name)
                    ->setValue($value)
                    ->save();

            $this->settings[$name] = $model;
        } else {
            // Update
            $this->settings[$name]->setValue($value);
            $this->settings[$name]->save();
        }
    }

    /**
     * Save settings from array
     *
     * @param  $data
     * @return bool
     */
    public function fromArray(array $data, $create = true) {
        if (sizeof($data) > 0) {
            if (array_key_exists('Locale', $data)) {
                $locale = $data['Locale'];
                unset($data['Locale']);
            } else
                $locale = null;

            foreach ($data as $key => $value) {
                $this->set($key, $value, $create, $locale);
            }
        } else {
            return false;
        }
    }

    /**
     * Get param value
     *
     * @param  $name
     * @return string or null
     */
    public function __get($name) {
        if ($name == 'pricePrecision') {
            return \Currency\Currency::create()->mainPricePrecision;
        }
        if (array_key_exists($name, $this->settings))
            return $this->settings[$name]->getValue();
        else
            return null;
    }

    public function isTranslatable($fieldName) {
        $translatableFields = $this->getTranslatableFields();

        if (in_array($fieldName, $translatableFields)) {
            return TRUE;
        }

        return FALSE;
    }

    public function getTranslatableFields() {
        return array(
            /* Внешний вид */

            /* Изображения */

            /* Заказы - Уведомление покупателя о совершении заказа */
            'ordersSenderName', //Имя отправителя
            'ordersMessageTheme', //Тема сообщения
            'ordersMessageText', //Текст сообщения

            /* Заказы - Уведомление покупателя о смене статуса заказа */
            'notifyOrderStatusSenderName', //Имя отправителя
            'notifyOrderStatusMessageTheme', //Тема сообщения
            'notifyOrderStatusMessageText', //Формат сообщения

            /* WishList'ы */
            'wishListsSenderName', //Имя отправителя
            'wishListsMessageTheme', //Тема сообщения
            'wishListsMessageText', //Текст сообщения

            /* Уведомление о появлении */
            'notificationsSenderName', //Имя отправителя
            'notificationsMessageTheme', //Тема сообщения
            'notificationsMessageText', //Текст сообщения

            /* Оповещение о новом Callback'е */
            'callbacksSenderName', //Имя отправителя
            'callbacksMessageTheme', //Тема сообщения
            'callbacksMessageText', //Текст сообщения

            /* Автоматическая регистрация пользователя после заказа */
            'userInfoSenderName', //Имя отправителя
            'userInfoMessageTheme', //Тема сообщения
            'userInfoMessageText', //Текст сообщения

            /* Блок Топ-продаж */

            /* Восстановления пароля */
            'forgotPasswordMessageText', //Текст сообщения

            /* Уведомления */
            //'adminMessageIncoming',
            //'adminMessageCallback',
            //'adminMessageOrderPage'
            'adminMessages'
        );
    }

    public function getSelectedCats() {
        $arr = $this->__get('selectedProductCats');
        $arr = unserialize($arr);
        return $arr;
    }

    public function getIsAdult() {
        return $this->__get('isAdult');
    }

    public function isselected($a) {
        /* TODO: remove if the functionality is not present */
        $i = $this->getSelectedCats();
        foreach ($i as $j) {
            if ((int) $j == (int) $a)
                echo "selected";
        }
    }

    public function getMessage($msg) {
        
    }

    public function getimagesizes() {
        $result['mainimage']['width'] = $this->__get('mainImageWidth');
        $result['mainimage']['height'] = $this->__get('mainImageHeight');
        $result['smallimage']['width'] = $this->__get('smallImageWidth');
        $result['smallimage']['height'] = $this->__get('smallImageHeight');
        $result['mainmodimage']['width'] = $this->__get('mainModImageWidth');
        $result['mainmodimage']['height'] = $this->__get('mainModImageHeight');
        $result['smallmodimage']['width'] = $this->__get('smallModImageWidth');
        $result['smallmodimage']['height'] = $this->__get('smallModImageHeight');
        return $result;
    }

    public function getss_settings() {
        $arr = $this->__get('ss');
        $arr = unserialize($arr);
        return $arr;
    }

    public function getOS() {
        $arr = $this->__get('1CSettingsOS');
        if ($arr) {
            $arr = unserialize($arr);
            return $arr;
        }
    }

    public function getSortingFront($order_id = FALSE) {
        $CI = & get_instance();
        $locale = MY_Controller::getCurrentLocale();
        $sortings = $CI->db
                ->select('shop_sorting_i18n.name_front, shop_sorting_i18n.tooltip, shop_sorting.get, shop_sorting.id')
                ->order_by('pos')
                ->where('active', 1)
                ->where('shop_sorting_i18n.locale', $locale)
                ->join('shop_sorting_i18n', 'shop_sorting_i18n.id=shop_sorting.id')
                ->get('shop_sorting')
                ->result_array();

        if ($order_id) {
            foreach ($sortings as $key => $sort) {
                if ($sort['id'] == $order_id) {
                    array_unshift($sortings, $sort);
                    unset($sortings[$key]);
                    break;
                }
            }
        }
        return $sortings;
    }

}
