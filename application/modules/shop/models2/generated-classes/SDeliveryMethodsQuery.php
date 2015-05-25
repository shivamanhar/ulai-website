<?php 

 use Base\SDeliveryMethodsQuery as BaseSDeliveryMethodsQuery;


 use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for performing query and update operations on the 'shop_delivery_methods' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SDeliveryMethodsQuery extends BaseSDeliveryMethodsQuery {

    public function enabled($enabled=true)
    {
        return $this->where('SDeliveryMethods.Enabled =?', $enabled);
    }
    
    public function joinWithI18n($locale = 'ru', $joinType = null)
	{
        if ($joinType == null)
        {
            switch (ShopController::getShowUntranslated()) {
                case FALSE:
                    $joinType = Criteria::INNER_JOIN;
                    break;
                default:
                    $joinType = Criteria::LEFT_JOIN;
                    break;
            }
        }        
        
        parent::joinWithI18n($locale, $joinType);
		return $this;
	}

} // SDeliveryMethodsQuery
