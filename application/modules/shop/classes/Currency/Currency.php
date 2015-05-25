<?php

namespace Currency;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Class Currency
 * @uses \ShopController
 * @author v.dushko <v.dushko
 * @copyright (c) 2014, ImageCMS
 * @package class Currency
 * @property \SCurrencies $main 
 */
class Currency extends \ShopController {

    protected static $_Currency;
    protected $currencies = array();
    public $default = null; // Default currency.
    public $current = null; // Currency to convert to.
    public $additional = null; // Currency to convert to.
    public $main = null; // Main currency.
    public $mainPricePrecision;

    function __construct() {
        parent::__construct();
        $currencies = \SCurrenciesQuery::create()->orderByMain('DESC')->find();

        foreach ($currencies as $c) {
            /**
             *  Set main currency & current
             */
            if ($c->getMain() == true) {
                $this->main = $c;
                $this->current = $c;
            }

            /**
             *  Set default currency
             */
            if ($c->getIsDefault() == true) {
                $this->default = $c;
            }

            $this->currencies[$c->getId()] = $c;
        }

        if ($this->current == NULL) {
            $this->current = $currencies['0'];
            $this->main = $currencies['0'];
            $this->default = $currencies['0'];
        }
        $tempPrecision = unserialize($this->main->currency_template);
        $this->mainPricePrecision = $tempPrecision['Decimal_places'];
    }

    /**
     * Function create()
     * @return \Currency\Currency
     */
    public static function create() {
        (null !== self::$_Currency) OR self::$_Currency = new self();
        return self::$_Currency;
    }

    /**
     * Convert price from default or selected currency to another currency
     *
     * @uses convertBody()
     * @param integer $price Price to convert
     * @access public
     * @return string Converted price
     */
    public function convert($price, $currencyId = null) {
        $convertBody = $this->convertBody($price, $currencyId);

        $pricePrecision = $convertBody['pricePrecision'];
        $price = $convertBody['price'];

        return ($price == round($price)) ? $price : number_format(round($price, $pricePrecision), $pricePrecision, '.', '');
    }

    /**
     * Convert price from default or selected currency to another currency for BUTTON BUY in variant
     *
     * @uses convertBody()
     * @param integer $price Price to convert
     * @access public
     * @return string Converted price
     */
    public function convertForTemplate($price, $currencyId = null) {
        $convertBody = $this->convertBody($price, $currencyId);
        $pricePrecision = $convertBody['pricePrecision'];
        $price = $convertBody['price'];
        $currencyId = $currencyId ? $currencyId : $this->main->getId();

        $price = ($price == round($price)) ? $price : number_format(round($price, $pricePrecision), $pricePrecision, '.', '');
        $price = $this->getCurrencyToFormat($currencyId, $price, NULL, NULL, NULL, NULL, NULL, NULL, TRUE);
        return $price;
    }

    /**
     * Convert price from default or selected currency to another currency
     *
     * @uses convertBody()
     * @param integer $price Price to convert
     * @access public
     * @return float Converted price
     */
    public function convertnew($price, $currencyId = null) {
        $convertBody = $this->convertBody($price, $currencyId);
        return round($convertBody['price'], $convertBody['pricePrecision']);
    }

    /**
     * Helper function to convertnew() and convert()
     *
     * @param integer $price Price to convert
     * @access public
     * @return array('pricePrecision', 'price')
     */
    private function convertBody($price, $currencyId = null) {
        $currency = ($currencyId != null && isset($this->currencies[$currencyId])) ? $this->currencies[$currencyId] : $this->current;

        return array('pricePrecision' => \ShopCore::app()->SSettings->pricePrecision,
            'price' => $price * $currency->getRate()
        );
    }

    /**
     * Convert sum from one currency to another
     * @param float $sum Price to convert
     * @param integer $from id carruncy
     * @access public
     * @return float 
     */
    public function convertToMain($sum, $from) {
        if ($from == $this->main->getId())
            return $sum;

        $from = $this->currencies[$from];
        $to = $this->main;

        $v1 = $from->getRate() / $to->getRate();
        return round($sum / $v1, 2);
    }

    /**
     * Get current currency symbol
     *
     * @access public
     * @return string
     */
    public function getSymbol() {
        if ($this->current instanceof \SCurrencies) {
            return $this->current->getSymbol();
        }
    }

    /**
     * Get current currency symbol by id
     *
     * @param integer $id Currency id to get symbol.
     * @access public
     * @return string
     */
    public function getSymbolById($id = null) {
        if ($id != null)
            $model = \SCurrenciesQuery::create()->findPk($id);

        return (count($model) > 0) ? $model->getSymbol() : false;
    }

    /**
     * Exchange rate by filter
     * 
     * @return string
     */
    public function getRateByfilter() {
        $model = \SCurrenciesQuery::create()->filterByIsDefault(1)->findOne();
        if ($model)
            return $model->getRate();
    }

    /**
     * Exchange rate by filter
     * @param int $id id currency
     * @return string
     */
    public function getRateById($id = null) {
        if ($id != null)
            $model = \SCurrenciesQuery::create()->findPk($id);
        return (count($model) > 0) ? $model->getRate() : false;
    }

    /**
     * Get currencies array
     *
     * @access public
     * @return array currencies
     */
    public function getCurrencies() {
        return $this->currencies;
    }

    /**
     * Change the current currency
     * @param string(main or default)|int(id currency) $id Description
     * @access public
     */
    public function initCurrentCurrency($id = null) {
        if ($id == 'main') {
            $this->current = $this->main;
            return true;
        }

        if ($id == 'default') {
            $this->current = $this->default;
            return true;
        }

        if ($id === null) {
            // Set current currency from default
            $this->current = $this->default;
        } else {
            // Check if currency exists.
            if (isset($this->currencies[$id])) {
                $this->current = $this->currencies[$id];
            } else {
                $this->current = $this->default;
            }
        }
    }

    /**
     * Change the additional currency
     * @param int(id currency) $id Description
     * @access public
     */
    public function initAdditionalCurrency($id = null) {
        if (isset($this->currencies[$id]))
            $this->additional = $this->currencies[$id];
    }

    /**
     * Get main currency
     * @param int(id currency) $id Description
     * @access public
     */
    public function getMainCurrency() {
        return $this->main;
    }

    public function getCurrencyDecimalPlaces($currencyId) {
        if (!isset($this->currencies[$currencyId])) {
            return FALSE;
        }
        $currency = $this->currencies[$currencyId];
        $currencyTamplate = unserialize($currency->getCurrencyTemplate());
        $DecimalPlaces = $currencyTamplate['Decimal_places'];
        return $DecimalPlaces;
    }

    /**
     * Used for displaying prices in all admin panel
     * 
     * Return price with number of decimal places according to:
     *      - second parameter currency settings
     *      - or main currency settings if second parameter = FALSE
     * @uses in /products/default_edit.tpl
     * @uses in /search/list.tpl
     * @uses in /products/create.tpl
     * @uses in /deliverymethods/list.tpl
     * @param float $price
     * @param int $currencyId
     * @return string
     */
    public function decimalPointsFormat($price, $currencyId = FALSE) {
        if (FALSE === $currencyId) {
            $currencyId = $this->main->getId();
        }
        if (FALSE === ($decimalPlaces = $this->getCurrencyDecimalPlaces($currencyId))) {
            $decimalPlaces = 2;
        }
        return number_format($price, $decimalPlaces, '.', '');
    }

    /**
     * Resulting sum in the main currency in the currency specified
     * @param float $price
     * @param int $id
     * @return float 
     */
    public function toMain($price, $id = null) {
        if (null === $id)
            $id = $this->main->getId();
        $rate = $this->getRateById($id);
        return $price / $rate;
    }

    /**
     * Update don`t correct prices
     * @param bool $fix Must report or not
     * @return bool Were found and fixed an incorrect price
     */
    public function checkPrices($fix = false) {
        $incorrectIds = array();

        //check prices in all currencies
        foreach ($this->currencies as $currency) {
            $find = $this->db->query("SELECT * FROM `shop_product_variants` WHERE `currency`=" . $currency->getId())->num_rows();
            $incorrect = $this->db->query("SELECT * FROM `shop_product_variants` WHERE `currency`=" . $currency->getId() . " AND ROUND(`price`*" . $currency->getRate() . ", 2)!=ROUND(`price_in_main`, 2)")->num_rows();
            if ($incorrect > 0) {
                $incorrectIds[$currency->getId()]['query'] = " WHERE `currency`=" . $currency->getId() . " AND ROUND(`price`/" . $currency->getRate() . ", 2)!=ROUND(`price_in_main`, 2)";
                $incorrectIds[$currency->getId()]['rate'] = $currency->getRate();
            }

            /* Report */
            if ($fix) {
                echo "В " . $currency->getName() . ": " . $find . " (" . $incorrect . ")";
                echo "</br>";
            }
        }

        /* Update don`t correct prices */
        if (count($incorrectIds) > 0) {
            $updated_rows = 0;
            foreach ($incorrectIds as $item) {
                $this->db->query("UPDATE `shop_product_variants` SET `price`=`price_in_main`/" . $item['rate'] . $item['query']);
            }
            return true;
        } else
            return false;
    }

    /**
     * Conclusion currency specified format
     * @param int $id id currency in which to convert
     * @param float $price
     * @param str $tagSymbol html tag (only the word). Example('span' -> <span></span> or 'p' -> <p></p>...)   
     * @param str $classSymbol class tag (only the word). Example('class1' -> <span class='class1'></span>)
     * @param str $htmlIdSymbol id tag (only the word). Example('id2' -> <span id='id2'></span>)
     * @param str $tagPrice html tag (only the word). Example('span' -> <span></span> or 'p' -> <p></p>...)   
     * @param str $classPrice class tag (only the word). Example('class1' -> <span class='class1'></span>)
     * @param str $htmlIdPrice id tag (only the word). Example('id2' -> <span id='id2'></span>)
     * @return string or bool(false)
     */
    public function getCurrencyToFormat($id, $price, $tagSymbol = NULL, $classSymbol = NULL, $htmlIdSymbol = NULL, $tagPrice = NULL, $classPrice = NULL, $htmlIdPrice = NULL, $convertForTemplate = false) {

        if (!$id)
            return FALSE;

        $format = unserialize($this->currencies[$id]->getCurrencyTemplate());
        if (!$format || !$format['Format']) {
            $format["Thousands_separator"] = ".";
            $format["Separator_tens"] = ",";
            $format["Decimal_places"] = "1";
            $format["Zero"] = "1";
            $format["Format"] = "# " . $this->currencies[$id]->getSymbol();            
            $this->db->where('id',$id)->update('shop_currencies', array('currency_template' => serialize($format)));
        }
        if (empty($format) && !is_array($format))
            return FALSE;
        /* Getting cyrrency symbol */
        $symbolOrigin = trim(str_replace('#', "", $format['Format']));
        $symbolOriginClear = $symbolOrigin;
        $format['Format'] = trim(str_replace($symbolOrigin, '%zz%' . $symbolOrigin . '%zz%', $format['Format']));
        $symbolOrigin = '%zz%' . $symbolOrigin . '%zz%';
        /* The converted amount */
        $price = strtr($price, array(',' => '.'));
//       if($this->main->getId() != $id){
//            $price = $this->convertBody($price, $id);
//            $price = $price['price'];       
//       }

        /* fractional part */
        $decimal = $price - floor($price);
        /* integer part */
        $int = strrev($price - $decimal);
        /* price with delimiter */
        $str = strrev(implode($format['Thousands_separator'], str_split($int, 3)));
        /* If $ format ['Zero'] is not output at the end of the sum 0 */
        if ($format['Decimal_places']) {
            $decimalNew = round($decimal, $format['Decimal_places']);
            if ($decimalNew) {
                $decimalNew = substr($decimalNew, 2);
                if (strlen($decimalNew) < $format['Decimal_places']) {
                    for ($i = strlen($decimalNew); $i < $format['Decimal_places']; $i++)
                        $decimalNew.=0;
                }
            } else {
                if ($format['Zero']) {
                    $format['Separator_tens'] = '';
                    $decimalNew = '';
                } else {
                    for ($i = 1; $i < $format['Decimal_places']; $i++)
                        $decimalNew.=0;
                }
            }
            $str.=$format['Separator_tens'] . $decimalNew;
        }

        /* envelop tag */
        if ($tagPrice) {
            if ($classPrice && $htmlIdPrice) {
                $str = ' <' . $tagPrice . ' id="' . $htmlIdPrice . '" class="' . $classPrice . '">' . $str . '</' . $tagPrice . '> ';
            } elseif ($classPrice && !$htmlIdPrice) {
                $str = ' <' . $tagPrice . ' class="' . $classPrice . '">' . $str . '</' . $tagPrice . '> ';
            } elseif (!$classPrice && $htmlIdPrice) {
                $str = ' <' . $tagPrice . ' id="' . $htmlIdPrice . '">' . $str . '</' . $tagPrice . '> ';
            } else {
                $str = ' <' . $tagPrice . '>' . $str . '</' . $tagPrice . '> ';
            }
        } else {
            $str = ' ' . $str . ' ';
        }
        /* envelop tag */
        if ($tagSymbol) {
            if ($classSymbol && $htmlIdSymbol) {
                $symbol = ' <' . $tagSymbol . ' id="' . $htmlIdSymbol . '" class="' . $classSymbol . '">' . $symbolOrigin . '</' . $tagSymbol . '> ';
            } elseif ($classSymbol && !$htmlIdSymbol) {
                $symbol = ' <' . $tagSymbol . ' class="' . $classSymbol . '">' . $symbolOrigin . '</' . $tagSymbol . '> ';
            } elseif (!$classSymbol && $htmlIdSymbol) {
                $symbol = ' <' . $tagSymbol . ' id="' . $htmlIdSymbol . '">' . $symbolOrigin . '</' . $tagSymbol . '> ';
            } else {
                $symbol = ' <' . $tagSymbol . '>' . $symbolOrigin . '</' . $tagSymbol . '> ';
            }
        } else {
            $symbol = ' ' . $symbolOrigin . ' ';
        }
        if ($convertForTemplate) {
            //На кнопке варианта есть цена, которая просто подставляется без символа валюты.
            return $str;
        }
        $sym = $symbol ? $symbol : $symbolOrigin;
        $sym = str_replace($symbolOrigin, $symbolOriginClear, $sym);

        $returnStr = strtr($format['Format'], array('#' => $str));
        $returnStr = strtr($returnStr, array($symbolOrigin => $sym));

        return $returnStr;
    }

}
