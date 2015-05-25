<?php

use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Load and prepare shop discounts
 *
 * Date: 12.01.2011
 * Time: 12:12:21
 * author: dev
 */
class SDiscountsManager {

    public $discounts = array();
    public $comulativ = true;
    public $DFA = true;

    public function __construct() {
        if (!ShopCore::$ci->dx_auth->is_logged_in() && !$this->DFA)
            return FALSE;


        if ($this->DFA && ShopCore::$ci->dx_auth->is_logged_in())
            $model = SUserProfileQuery::create()
                    ->orderByDiscount()
                    ->findOneById(ShopCore::$ci->dx_auth->get_user_id());



        elseif (ShopCore::$ci->dx_auth->is_logged_in())
            $model = SUserProfileQuery::create()
                    ->orderByDiscount()
                    ->findOneById(ShopCore::$ci->dx_auth->get_user_id());

        if ($model) {

            if (($model->getDiscount() === Null OR $model->getDiscount() == 0) && !$this->DMA) {


                $result = ShopComulativQuery::create()
                        ->orderByTotalA(Criteria::DESC)
                        ->condition('cond1', 'ShopComulativ.Total <= ?', $model->getAmout())
                        ->condition('cond2', 'ShopComulativ.TotalA >= ?', $model->getAmout())
                        ->condition('cond4', 'ShopComulativ.Active = 1')
                        ->where(array('cond1', 'cond2', 'cond4'), Criteria::LOGICAL_AND)
                        ->condition('cond5', 'ShopComulativ.Active = 1')
                        ->condition('cond6', 'ShopComulativ.TotalA <= ?', $model->getAmout())
                        ->_or()
                        ->where(array('cond5', 'cond6'), Criteria::LOGICAL_AND)
                        ->findOne();

                if ($result) {
                    $this->comulativ = false;
                    $this->discounts[] = $result;
                }
            } elseif ($model->getDiscount() !== Null) {
                $this->comulativ = false;
                $this->discounts[] = $model;
            } else {
                $this->comulativ = true;
            }
        } else {
            $this->comulativ = true;
        }

        if ($this->comulativ === true) {


            $timeNow = date('U');

            $discounts = ShopDiscountsQuery::create()
                    ->filterByActive(true)
                    ->orderBy('ShopDiscounts.Discount', Criteria::DESC)
                    ->where('ShopDiscounts.DateStart <= ?', $timeNow)
                    ->where('ShopDiscounts.DateStop >= ?', $timeNow)
                    ->find();

            if (count($discounts) > 0) {

                foreach ($discounts as $d) {
                    // Create categories array
//                    $categoriesArray = unserialize($d->getCategories());
//                    if (!is_array($categoriesArray))
//                        $categoriesArray = array();
                    // Check what to type of discount to use
                    $d->setVirtualColumn('UsePercentage', true);

                    $d->setDiscount(str_replace('%', '', $d->getDiscount()));

                    // Create products array
//                    $productIds = array();
//                    if ($d->getProducts() != '') {
//                        $productIds = explode(',', $d->getProducts());
//                        if (!is_array($productIds))
//                            $productIds = array();
//
//                        $productIds = array_map('trim', $productIds);
//                    }
                    //$d->setVirtualColumn('ProductsArray', $productIds);
                    //$d->setVirtualColumn('CategoriesArray', $categoriesArray);
                    $this->discounts[$d->getId()] = $d;
                }
            } else {
                return FALSE;
            }
        }return false;
    }

    public function getActive() {
        return $this->discounts;
    }

    public function getComulativ() {
        return $this->comulativ;
    }

}

