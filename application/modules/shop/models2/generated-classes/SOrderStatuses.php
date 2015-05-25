<?php

use Base\SOrderStatuses as BaseSOrderStatuses;

use Propel\Runtime\Map\TableMap;
use Map\SOrderStatusesI18nTableMap;

/**
 * Skeleton subclass for representing a row from the 'shop_order_statuses' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SOrderStatuses extends BaseSOrderStatuses {

    public function attributeLabels() {
        return array(
            'Name' => ShopCore::t('Название'),
            'Position' => ShopCore::t('Позиция'),
        );
    }

    public function rules() {
        return array(
            array(
                'field' => 'Name',
                'label' => $this->getLabel('Name'),
                'rules' => 'required',
            ),
        );
    }

    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME) {
        $keys = SOrderStatusesI18nTableMap::getFieldNames($keyType);

        if (array_key_exists('Locale', $arr)) {
            $this->setLocale($arr['Locale']);
            unset($arr['Locale']);
        } else {
            $defaultLanguage = getDefaultLanguage();
            $this->setLocale($defaultLanguage['identif']);
        }

        foreach ($keys as $key)
            if (array_key_exists($key, $arr)) {
                $methodName = set . $key;
                $this->$methodName($arr[$key]);
            }

        parent::fromArray($arr, $keyType);
    }

}

// SOrderStatuses
