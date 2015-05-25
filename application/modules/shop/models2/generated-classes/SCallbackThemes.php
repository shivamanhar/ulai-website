<?php

use Base\SCallbackThemes as BaseSCallbackThemes;
use Propel\Runtime\Map\TableMap;
use Map\SCallbackThemesI18nTableMap;

/**
 * Skeleton subclass for representing a row from the 'shop_callbacks_themes' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SCallbackThemes extends BaseSCallbackThemes {

    public function attributeLabels() {
        return array(
            'Text' => ShopCore::t('Название'),
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

    public function preSave() {
        $this->setPosition((int) $this->getPosition());
        return true;
    }

    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME) {
        $keys = SCallbackThemesI18nTableMap::getFieldNames($keyType);

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

// SCallbackThemes
