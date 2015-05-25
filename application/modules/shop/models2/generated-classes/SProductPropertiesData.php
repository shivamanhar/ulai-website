<?php 

 use Base\SProductPropertiesData as BaseSProductPropertiesData;

/**
 * Skeleton subclass for representing a row from the 'shop_product_properties_data' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SProductPropertiesData extends BaseSProductPropertiesData {

    public function setValue($v) {
        parent::setValue(htmlspecialchars($v));
    }

    public function getSProperties(PropelPDO $con = null) {

        return SPropertiesQuery::create()->joinWithI18n(MY_Controller::getCurrentLocale())
                        ->filterbyid($this->property_id)->findone();
    }

}

// SProductPropertiesData