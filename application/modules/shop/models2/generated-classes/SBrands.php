<?php 

 use Base\SBrands as BaseSBrands;
 use Map\SBrandsTableMap;
 use Map\SBrandsI18nTableMap;
 

/**
 * Skeleton subclass for representing a row from the 'shop_brands' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SBrands extends BaseSBrands {

    public function __construct() {
        parent::__construct();
        $this->currentLocale = \MY_Controller::getCurrentLocale();
    }

    public function attributeLabels() {
        return array(
            'Name' => ShopCore::t(lang('Name', 'admin')),
            'Url' => ShopCore::t(lang('URL', 'admin')),
            'Description' => ShopCore::t(lang('Описание', 'admin')),
            'MetaTitle' => ShopCore::t('Meta Title'),
            'MetaDescription' => ShopCore::t('Meta Description'),
            'MetaKeywords' => ShopCore::t('Meta Keywords'),
        );
    }

    public function rules() {
        return array(
            array(
                'field' => 'Name',
                'label' => $this->getLabel('Name'),
                'rules' => 'required'
            ),
            array(
                'field' => 'Url',
                'label' => $this->getLabel('Url'),
                'rules' => 'alpha_dash',
            ),
        );
    }

    public function postSave() {
        if ($this->getUrl() == '') {
            ShopCore::$ci->load->helper('translit');
            $this->setUrl(translit_url($this->getName()));
            $this->save();
        }

        return true;
    }

    /**
     * Populates the translatable object using an array.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return     void
     */
    public function fromArray($arr, $keyType = SBrandsTableMap::TYPE_PHPNAME) {
        $keys = SBrandsI18nTableMap::getFieldNames($keyType);

        if (array_key_exists('Locale', $arr)) {
            $this->setLocale($arr['Locale']);
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

    public function getTranslatableFieldNames($keyType = TableMap::TYPE_PHPNAME) {
        $peerName = get_class($this) . I18nPeer;
        $keys = $peerName::getFieldNames($keyType);
        $keys = array_flip($keys);

        if (array_key_exists('Locale', $keys)) {
            unset($keys['Locale']);
        }

        if (array_key_exists('Id', $keys)) {
            unset($keys['Id']);
        }

        return array_flip($keys);
    }

    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false) {
        $result = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, $includeForeignObjects);

        $translatableFieldNames = $this->getTranslatableFieldNames();
        foreach ($translatableFieldNames as $fieldName) {
            $methodName = 'get' . $fieldName;
            $result[$fieldName] = $this->$methodName();
        }

        return $result;
    }

    public function translatingRules() {
        $rules = $this->rules();
        $translatingRules = array();
        $translatableFieldNames = $this->getTranslatableFieldNames();

        foreach ($rules as $rule) {
            if (in_array($rule['field'], $translatableFieldNames)) {
                $translatingRules[$rule['field']] = $rule['rules'];
            }
        }

        return $translatingRules;
    }

}

// SBrands
