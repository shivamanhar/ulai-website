<?php

/**
 * SCurrencyHelper
 * 
 * @package
 * @version $id$
 * @copyright
 * @author <dev
 * @license
 * @deprecated since version 4.6.1
 */
class SCurrencyHelper {

    public function __construct() {
        
    }

    /**
     * Convert price from default or selected currency to another currency
     *
     * @param integer $price Price to convert
     * @access public
     * @return integer Converted price
     * @deprecated since version 4.6.1
     */
    public function convert($price, $currencyId = null) {
        return \Currency\Currency::create()->convert($price, $currencyId);
    }

    public function convertnew($price, $currencyId = null) {
        return \Currency\Currency::create()->convertnew($price, $currencyId);
    }

    /**
     * Convert sum from one currency to another
     * @deprecated since version 4.6.1
     */
    public function convertToMain($sum, $from) {
        return \Currency\Currency::create()->convertToMain($sum, $from);
    }

    /**
     * Get current currency symbol
     *
     * @param integer $id Currency id to get symbol.
     * @access public
     * @return string
     * @deprecated since version 4.6.1
     */
    public function getSymbol($id = null) {
        return \Currency\Currency::create()->getSymbol();
    }

    /**
     * Get current currency symbol by id
     *
     * @param integer $id Currency id to get symbol.
     * @access public
     * @return string
     * @deprecated since version 4.6.1
     */
    public function getSymbolById($id = null) {
        return \Currency\Currency::create()->getSymbolById($id);
    }

    /**
     * @deprecated since version 4.6.1
     * 
     */
    public function getRateByfilter() {
        return \Currency\Currency::create()->getRateByfilter();
    }

    /**
     * @deprecated since version 4.6.1
     * 
     */
    public function getRateById($id = null) {
        return \Currency\Currency::create()->getRateById($id);
    }

    /**
     * Get currencies array
     *
     * @access public
     * @return SCurrencies
     * @deprecated since version 4.6.1
     */
    public function getCurrencies() {
        return \Currency\Currency::create()->getCurrencies();
    }

    /**
     * @deprecated since version 4.6.1
     * 
     */
    public function initCurrentCurrency($id = null) {
        return \Currency\Currency::create()->initCurrentCurrency($id);
    }

    /**
     * @deprecated since version 4.6.1
     * 
     */
    public function initAdditionalCurrency($id = null) {
        return \Currency\Currency::create()->initAdditionalCurrency($id);
    }

    /**
     * @deprecated since version 4.6.1
     * 
     */
    public function getmaincurr() {
        return \Currency\Currency::create()->getMainCurrency();
    }

    /**
     * @deprecated since version 4.6.1
     * 
     */
    public function checkPrices($fix = false) {
        return \Currency\Currency::create()->checkPrices($fix);
    }

    /**
     * @deprecated since version 4.6.1
     * 
     */
    public function toMain($price, $id = null) {
        return \Currency\Currency::create()->toMain($price, $id);
    }

}
