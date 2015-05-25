<?php

use Base\CustomFieldsQuery as BaseCustomFieldsQuery;

//include '/home/koloda/sites/bigtrucksale/www/bigtracksale/application/modules/shop/models/build/classes/Shop/om/BaseCustomFieldsQuery.php';

/**
 * Skeleton subclass for performing query and update operations on the 'custom_fields' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class CustomFieldsQuery extends BaseCustomFieldsQuery {

    public function joinWithI18n($locale = 'ru', $joinType = null) {
        if ($joinType == null) {
            switch (ShopController::getShowUntranslated()) {
                case FALSE:
                    $joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN;
                    break;
                default:
                    $joinType = \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN;
                    break;
            }
        }

        parent::joinWithI18n($locale, $joinType);
        return $this;
    }

}

// CustomFieldsQuery
