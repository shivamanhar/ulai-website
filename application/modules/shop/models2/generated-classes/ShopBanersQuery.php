<?php 

 use Base\ShopBanersQuery as BaseShopBanersQuery;



/**
 * Skeleton subclass for performing query and update operations on the 'shop_banners' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class ShopBanersQuery extends BaseShopBanersQuery 
{
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

} // ShopBanersQuery
