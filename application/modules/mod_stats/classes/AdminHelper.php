<?php

namespace mod_stats\classes;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class AdminHelper for mod_stats module
 * @uses \MY_Controller
 * @author DevImageCms
 * @copyright (c) 2014, ImageCMS
 * @property stats_model $stats_model
 * @package ImageCMSModule
 */
class AdminHelper extends \MY_Controller {

    protected static $_instance;

    /**
     * __construct base object loaded
     * @access public
     * @author DevImageCms
     * @param ---
     * @return ---
     * @copyright (c) 2013, ImageCMS
     */
    public function __construct() {
        parent::__construct();
        /** Load model * */
        $this->load->model('stats_model');
        $lang = new \MY_Lang();
        $lang->load('mod_stats');
    }

    /**
     *
     * @return AdminHelper
     */
    public static function create() {
        (null !== self::$_instance) OR self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Ajax update setting by value and setting name
     */
    public function ajaxUpdateSettingValue() {
        /** Get data from post * */
        $settingName = $this->input->get('setting');
        $settingValue = $this->input->get('value');

        /** Set setting value * */
        $result = $this->stats_model->updateSettingByNameAndValue($settingName, $settingValue);

        /** Return result * */
        if ($result) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    /**
     * Get setting by value
     * @param string $settingName
     * @return string|boolean
     */
    public function getSetting($settingName) {
        return $this->stats_model->getSettingByName($settingName);
    }

    /**
     * Get main currency symbol
     * @return string
     */
    public function getCurrencySymbol() {
        return $this->stats_model->getMainCurrencySymbol();
    }

    /**
     * Autocomlete products
     * @return jsone
     */
    public function autoCompleteProducts() {
        $sCoef = $this->input->get('term');
        $sLimit = $this->input->get('limit');

        $products = $this->stats_model->getProductsByIdNameNumber($sCoef, $sLimit);

        if ($products != false) {
            foreach ($products as $product) {
                $response[] = array(
                    'value' => $product['name'],
                    'id' => $product['id'],
                );
            }
            echo json_encode($response);
            return;
        }
        echo '';
    }

    /**
     * Autocomlete categories
     * @return jsone
     */
    public function autoCompleteCategories() {
        $sCoef = $this->input->get('term');
        $sLimit = $this->input->get('limit');

        $categories = $this->stats_model->getCategoriesByIdName($sCoef, $sLimit);

        if ($categories != false) {
            foreach ($categories as $category) {
                $response[] = array(
                    'value' => $category['name'],
                    'id' => $category['id'],
                );
            }
            echo json_encode($response);
            return;
        }
        echo '';
    }

}
