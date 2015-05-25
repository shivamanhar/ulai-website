<?php

use Base\SNotificationStatuses as BaseSNotificationStatuses;
use Propel\Runtime\Map\TableMap;
use \Map\SNotificationStatusesI18nTableMap;

/**
 * Skeleton subclass for representing a row from the 'shop_notification_statuses' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SNotificationStatuses extends BaseSNotificationStatuses {

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

    /**
     * Populates the translatable object using an array.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return     void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME) {
        $keys = SNotificationStatusesI18nTableMap::getFieldNames($keyType);

        if (array_key_exists('Locale', $arr)) {
            $this->setLocale($arr['Locale']);
            unset($arr['Locale']);
        } else {
            $this->setLocale(MY_Controller::defaultLocale());
        }

        foreach ($keys as $key)
            if (array_key_exists($key, $arr)) {
                $methodName = set . $key;
                $this->$methodName($arr[$key]);
            }

        parent::fromArray($arr, $keyType);
    }

}

// SNotificationStatuses
