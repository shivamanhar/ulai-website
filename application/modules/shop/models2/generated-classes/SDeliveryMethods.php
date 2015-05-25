<?php 

 use Base\SDeliveryMethods as BaseSDeliveryMethods;
 use Propel\Runtime\Map\TableMap;
 use Map\SDeliveryMethodsI18nTableMap;

/**
 * Skeleton subclass for representing a row from the 'shop_delivery_methods' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SDeliveryMethods extends BaseSDeliveryMethods {

    public function attributeLabels() {
        return array(
            'Name' => ShopCore::t('Название'),
            'Description' => ShopCore::t('Описание'),
            'Pricedescription' => ShopCore::t('Описание'),
            'Price' => ShopCore::t('Цена'),
            'FreeFrom' => ShopCore::t('Бесплатен от'),
            'Enabled' => ShopCore::t('Активен'),
            'delivery_sum_specified_message' => ShopCore::t('Сообщение про уточнение цени'),
        );
    }

    public function rules($flag = false) {
        if(!$flag){
            return array(
                array(
                    'field' => 'Name',
                    'label' => $this->getLabel('Name'),
                    'rules' => 'required|max_length[500]'
                ),
                array(
                    'field' => 'Price',
                    'label' => $this->getLabel('Price'),
                ),
                array(
                    'field' => 'FreeFrom',
                    'label' => $this->getLabel('FreeFrom'),
                    //'rules' => 'numeric',
                ),
            );
        } else {
            return array(
                array(
                    'field' => 'Name',
                    'label' => $this->getLabel('Name'),
                    'rules' => 'required|max_length[500]'
                ),
                array(
                    'field' => 'Price',
                    'label' => $this->getLabel('Price'),
                ),
                array(
                    'field' => 'FreeFrom',
                    'label' => $this->getLabel('FreeFrom'),
                    //'rules' => 'numeric',
                ),
                array(
                    'field' => 'delivery_sum_specified_message',
                    'label' => $this->getLabel('delivery_sum_specified_message'),
                    'rules' => 'required|max_length[500]',
                ),
            );
        }
    }

    /**
     * Populates the translatable object using an array.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return     void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME) {
        $keys = SDeliveryMethodsI18nTableMap::getFieldNames($keyType);

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

    /**
     * Get the value of [delivery_sum_specified_message] column.
     * 
     * @return     string
     */
    public function getDeliverySumSpecifiedMessage() {
        return $this->getCurrentTranslation()->getDeliverySumSpecifiedMessage();
    }

    /**
     * Set the value of [delivery_sum_specified_message] column.
     * 
     * @param      string $v new value
     * @return     SDeliveryMethods The current object (for fluent API support)
     */
    public function setDeliverySumSpecifiedMessage($v) {
        $this->getCurrentTranslation()->setDeliverySumSpecifiedMessage($v);

        return $this;
    }

}

// SDeliveryMethods
