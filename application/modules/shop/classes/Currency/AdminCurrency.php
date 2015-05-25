<?php
namespace Currency;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Class AdminCurrency
 * @uses \ShopController
 * @author v.dushko <v.dushko
 * @copyright (c) 2014, ImageCMS
 * @package class AdminCurrency
 */

class AdminCurrency extends \ShopController {
    
    protected static $_AdminCurrency;

    function __construct() {
        parent::__construct();      
    }

    /**
     * Function create()
     * @return \Currency\AdminCurrency
     * @access public
     */
    public static function create()
    {
        (null !== self::$_AdminCurrency) OR self::$_AdminCurrency = new self();        
        return self::$_AdminCurrency;
    }
    
    
    /**
     * Creating a new currency
     * @param string $name (required) currency name
     * @param string $code (required) currency ISO code ($ - USD, € - EUR ...)
     * @param string $symbol (required) currency symbol ($, € ...)
     * @param string $rate (required) relation to the main currency (1 main currency = $rate | 1 RUR(main) = 0.0310 $)
     * @return bool
     * @access public
     */
    public function createCurrency($name, $code, $symbol, $rate) {
        $array = array('Name'=>$name, 'Code'=>$code, 'Symbol'=>$symbol, 'Rate'=>$rate);
        foreach ($array as $value) {
            if(!$value || !is_string($value))
                return FALSE;
        }
        $model = new \SCurrencies;
        $array['CurrencyTemplate'] = serialize(array(
                'Thousands_separator' => '.',
                'Separator_tens' => ',',
                'Decimal_places' => '1',
                'Zero' => '1',
                'Format' => '# '.$symbol,
                ));
        $model->fromArray($array);
        $model->save();
        return TRUE;
    }
    
    /**
     * Editing currency
     * @param int $id (required) id currency
     * @param str $name (required) (name| main | is_default | code | symbol | rate | showOnSite)
     * @param str $param (required) (name = (str) | main = (0 or 1) | is_default= (0 or 1)
     * code = (str) | symbol = (str) | rate = (str) | showOnSite = (0 or 1))
     * @return boolean
     * @access public
     */
    public function editCurrency($id, $name, $param) {
        if(!$id || !$name || !$param)
            return FALSE;
        if(!preg_match("/".$name."/", "name| main | is_default | code | symbol | rate | showOnSite"))
            return FALSE; 
        
        if($name == 'main'){
            $this->db->update('shop_payment_methods',array('currency_id'=>$id));
        }
        
        $this->db->where('id', $id)
                ->update('shop_currencies', array($name=>$param));
        
        return TRUE;
    }
    
    /**
     * Edit the template output currency
     * @param int $id id currency which will be carried out changes
     * @param str $format ('$ #' OR '# $' OR '#rur' ....)
     * @param str $thousands_separator (.)thousands separator
     * @param str $separator_tens (,)separator tens
     * @param str $decimal_places (2)how many digits in the fractional part is
     * @param int $zero if the fractional part is 0,then 1 - display, 0 - do not display
     * @return boolean
     */
    public function editCurrencyFormat($id, $format, $thousands_separator = '', $separator_tens ='', $decimal_places = '2', $zero = 0) {
        if(!$id)
            return false;
        $CurrencyTemplate = serialize(array(
                    'Thousands_separator' => $thousands_separator,
                    'Separator_tens' => $separator_tens,
                    'Decimal_places' => $decimal_places,
                    'Zero' => $zero,
                    'Format' => $format
                ));
        
        $this->db->where('id', $id)
                ->update('shop_currencies', array('currency_template'=>$CurrencyTemplate));        
        return TRUE;
    } 
    
    /**
     * Delete currency by id and get report or not.
     * @param int $id (required) id currency
     * @param bool $report (required) get report for error
     * @return bool or str
     * @access public
     */
    public function deleteCurrency($id, $report = FALSE){
        if(!$id || !is_int($id))
            return ($report)?'Empty or not an integer id.':FALSE;
        
         $model = \SCurrenciesQuery::create()
                ->findPk($id);

        if ($model !== null && !$model->getMain() && !$model->getIsDefault()) {

            $paymentMethodsCount = \SPaymentMethodsQuery::create()
                    ->filterByCurrencyId($model->getId())
                    ->count();
            if ($paymentMethodsCount > 0) {
                return ($report)?'In payment systems used by the currency can not be deleted.':FALSE;
                exit;
            }

            $productVariantsCount = \SProductVariantsQuery::create()
                    ->filterByCurrency($model->getId())
                    ->count();
            if ($productVariantsCount > 0) {
                return ($report)?'In the currency used products can not be deleted.':FALSE;
                exit;
            }

            $model->delete();
            return ($report)?'Success':TRUE;
        }else{
            return ($report)?'This id does not exist, it is the main currency or currency default. Delete is not possible.':FALSE;
        }
    }
}
