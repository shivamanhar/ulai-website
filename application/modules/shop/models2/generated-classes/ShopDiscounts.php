<?php 

 use Base\ShopDiscounts as BaseShopDiscounts;



/**
 * Skeleton subclass for representing a row from the 'shop_discounts' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class ShopDiscounts extends BaseShopDiscounts {

    public $categoriesArray = null;

	public function attributeLabels()
	{
		return array(
			'Name'=>ShopCore::t(lang('Name','admin')),
			'Active'=>ShopCore::t(lang('Active','admin')),
			'Description'=>ShopCore::t(lang('Описание','admin')),
			'DateStart'=>ShopCore::t(lang('Start date','admin')),
			'DateStop'=>ShopCore::t(lang('Finish date','admin')),
			'Discount'=>ShopCore::t(lang('Discount','admin')),
			'Categories'=>ShopCore::t(lang('Category','admin')),
			'Products'=>ShopCore::t(lang('Product','admin')),
			'UserGroup'=>ShopCore::t(lang('Users group','admin')),
		);
	}

    public function rules()
    {
        return array(
           array(
                 'field'=>'Name',
                 'label'=>$this->getLabel('Name'),
                 'rules'=>'required'
              ),
           array(
                 'field'=>'Discount',
                 'label'=>$this->getLabel('Discount'),
                 'rules'=>'required|regex_match[/^[0-9%]/]',
              ),
           array(
             'field'=>'DateStart',
             'label'=>$this->getLabel('DateStart'),
             'rules'=>'required',
          ),
          array(
             'field'=>'DateStop',
             'label'=>$this->getLabel('DateStop'),
             'rules'=>'required',
          ),

        );
    }

    public function formatDateStart()
    {
        if ($this->getDateStart() != '')
            return date('Y-m-d H:i:s', $this->getDateStart());
        else
            return null;
    }

    public function formatDateStop()
    {
        if ($this->getDateStop() != '')
            return date('Y-m-d H:i:s', $this->getDateStop());
        else
            return null;
    }

    public function hasCategory($id)
    {
        if ($this->categoriesArray === null)
            $this->categoriesArray = unserialize($this->getCategories());

        if (in_array($id,$this->categoriesArray))
            return true;
        else
            return false;
    }

    public function getGroupsArray()
    {
        $result = unserialize($this->getUserGroup());
        if (!is_array($result))
            return array();
        
        return $result;
    }

} // ShopDiscounts
