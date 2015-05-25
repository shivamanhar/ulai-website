<?php 

 use Base\CustomFields as BaseCustomFields;



/**
 * Skeleton subclass for representing a row from the 'custom_fields' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class CustomFields extends BaseCustomFields {
    
    public function attributeLabels()
    {
            return array(
            	    'entity'	    =>	ShopCore::t(lang('Custom object','admin')),
                    'name'          =>  ShopCore::t(lang('Name','admin')),
                    'fLabel'        =>  ShopCore::t('Label'),
                    'type'          =>  ShopCore::t(lang('Field type','admin')),
                    'description'   =>  ShopCore::t(lang('Описание','admin')),
                    'is_required'   =>  ShopCore::t(lang('Custom required field','admin')),
                    'multiple'      =>  ShopCore::t(lang('Custom multiple field','admin')),
                    'possible_values'=> ShopCore::t(lang('Custom posibble list','admin')),
                    'validators'    =>  ShopCore::t(lang('Validations','admin')),
                    'is_active'     =>  ShopCore::t(lang('Custom active field','admin')),
                    'is_private'    =>  ShopCore::t(lang('Сustom private field','admin')),
                    'rules'         =>  ShopCore::t(lang('Custom right field','admin'))
            );
    }
    
    public function getPossibleValuesArray()
    {
        return unserialize($this->possible_values);
    }
    
    public function getPossibleValuesString()
    {
    	return implode( unserialize($this->possible_values), ', ');
    }

    public function rules()
    {
        return array(
           array(
                 'field'=>'name',
                 'label'=>$this->getLabel('name'),
                 'rules'=>'required|alpha|is_unique[custom_fields.field_name]'
              ),
            array(
                 'field'=>'fLabel',
                 'label'=>$this->getLabel('fLabel'),
                 'rules'=>'required'
              ),
        );
    }
    
    public function isMultiple()
    {
        if ($this->getOptions() == 'multiple')
            return true;
        else
            return false;
    }
    
    public function getCustomFieldData($entityId)
    {
    	return CustomFieldsDataQuery::create()
    			->filterByentityId($entityId)
    			->filterByfieldId($this->getId())
    			->findOne();
    }

} // CustomFields
