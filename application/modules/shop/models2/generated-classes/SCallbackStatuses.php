<?php

use Base\SCallbackStatuses as BaseSCallbackStatuses;
use Map\SCallbackStatusesI18nTableMap;
use Propel\Runtime\Map\TableMap;

/**
 * Skeleton subclass for representing a row from the 'shop_callbacks_statuses' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SCallbackStatuses extends BaseSCallbackStatuses {

    public function attributeLabels() {
        return array(
            'Text' => ShopCore::t(lang('Name', 'admin')),
        );
    }

    public function rules() {
        return array(
            array(
                'field' => 'Text',
                'label' => $this->getLabel('Text'),
                'rules' => 'required'
            ),
        );
    }

    public function postSave() {
        if ($this->getIsDefault() == true) {
            // Only one status can be as default
            SCallbackStatusesQuery::create()
                    ->where('SCallbackStatuses.Id !=?', $this->getPrimaryKey())
                    ->update(array(
                        'IsDefault' => false,
            ));
        }
        return true;
    }

    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME) {

        $keys = SCallbackStatusesI18nTableMap::getFieldNames($keyType);

        if (array_key_exists('Locale', $arr)) {
            $this->setLocale($arr['Locale']);
            unset($arr['Locale']);
        } else {
            $this->setLocale(MY_Controller::defaultLocale());
        }
   
        foreach ($keys as $key) {
            if (array_key_exists($key, $arr)) {
                $methodName = set . $key;
                $this->$methodName($arr[$key]);
            }
        }
        
        parent::fromArray($arr, $keyType);
    }

}

// SCallbackStatuses
