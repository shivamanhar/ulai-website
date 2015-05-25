<?php 

 use Base\SBrandsQuery as BaseSBrandsQuery;
 use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for performing query and update operations on the 'shop_brands' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SBrandsQuery extends BaseSBrandsQuery {

    public function joinWithI18n($locale = 'ru', $joinType = null) {
        if ($joinType == null) {
            switch (ShopController::getShowUntranslated()) {
                case FALSE:
                    $joinType = Criteria::INNER_JOIN;
                    break;
                default:
                    $joinType = Criteria::LEFT_JOIN;
                    break;
            }
        }

        return parent::joinWithI18n($locale, $joinType);
    }

}

// SBrandsQuery
