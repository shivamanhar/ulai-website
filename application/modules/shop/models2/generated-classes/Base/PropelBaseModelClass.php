<?php

namespace Base;

class PropelBaseModelClass {

    public $customFields;
    public $customData;
    public $hasCustomData = false;
    public $entityId;
    private $entities_locale = array('product');

    public function collectCustomData($entityName, $id) {
        $this->entityId = $id;
        $this->customFields = CustomFieldsQuery::create()->filterByIsActive(1)->filterByEntity($entityName)->find()->toArray($keyColumn = 'id');
        if (count($this->customFields)) {
            $this->hasCustomData = true;
        } else {
            return false;
        }
    }

    public function validateCustomData($validator) {

        if (!empty($this->entityName)) {
            $this->collectCustomData($this->entityName, $this->getId());
            if ($this->hasCustomData !== false) {
                foreach ($_POST['custom_field'] as $key_post => $value_post) {
                    foreach ($this->customFields as $key => $value) {
                        if ((int) $key_post == $value['Id']) {

                            $validator_str = '';
                            if ($value['IsRequired'] && $this->curentPostEntitySave($key)) {
                                $validator_str = 'required';
                            }
                            if ($value['Validators'] && $this->curentPostEntitySave($key)) {
                                $validator_str .='|' . $value['Validators'];
                            }
                            if ($validator_str) {
                                $validator->set_rules("custom_field[$key]", $value['name'], $validator_str);
                            }
                        }
                    }
                }
            }
        }
        return $validator;
    }

    public function saveCustomData() {

        if (in_array($this->entityName, $this->entities_locale)) {
            $locale = chose_language();
        } else {
            $locale = 'ru';
        }
        if ($this->hasCustomData === false) {
            $this->collectCustomData($this->entityName, $this->getId());
        }

        if ($_POST['custom_field']) {
            foreach ($_POST['custom_field'] as $key => $value) {
                //var_dump($key);
                //$fieldUpdated = false;
                foreach ($this->customFields as $fieldObject) {
                    if ((int) $key == $fieldObject['Id']) {

                        $objCustomData = CustomFieldsDataQuery::create()
                                ->filterByentityId($this->entityId)
                                ->filterByfieldId($key)
                                ->filterByLocale($locale)
                                ->findone();
                        if ($objCustomData) {
                            $objCustomData->setdata($value);
                            $objCustomData->save();
                            // $fieldUpdated = true;
                            break;
                        } else {
                            $fieldObject = new \CustomFieldsData();
                            $fieldObject->setentityId($this->entityId);
                            $fieldObject->setfieldId($key);
                            $fieldObject->setdata($value);
                            $fieldObject->setLocale($locale);
                            $fieldObject->save();
                            break;
                        }
                    }
                }
//                if (!$fieldUpdated && $this->curentPostEntitySave($key)) {
//
//                    $fieldObject = new CustomFieldsData();
//                    $fieldObject->setentityId($this->entityId);
//                    $fieldObject->setfieldId($key);
//                    $fieldObject->setdata($value);
//                    $fieldObject->save();
//                }
            }
        }
    }

    public function curentPostEntitySave($key) {
        $entity = CustomFieldsQuery::create()->findPk($key);
        if ($entity) {
            if ($entity->getEntity() == $this->entityName) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getLabel($attributeName) {
        if (method_exists($this, 'attributeLabels')) {
            $labels = $this->attributeLabels();

            if (isset($labels[$attributeName])) {
                return $labels[$attributeName];
            } else {
                return $attributeName;
            }
        }
    }

    public function getVirtual($column) {
        $column = strtolower($column);
        return $this->getVirtualColumn($column);
    }

    /**
     * Convert model attribute(by default Price). e.g. "99.99 $"
     *
     * @param string $attributeName Optional. Attribute name to convert.
     * @access public
     * @return string
     */
    public function toCurrency($attributeName = 'Price', $cId = null, $convertForTemplate = false) {
        $attributeName = strtolower($attributeName);
        $get = 'get' . $attributeName;
        
        if(!$convertForTemplate){ 
            if ($attributeName == 'origprice') {
                return \Currency\Currency::create()->convert($this->getVirtualColumn('origprice'), $cId);
            }
            return \Currency\Currency::create()->convert($this->$get(), $cId);
        }else{
            if ($attributeName == 'origprice') {
                return \Currency\Currency::create()->convertForTemplate($this->getVirtualColumn('origprice'), $cId);
            }
            return \Currency\Currency::create()->convertForTemplate($this->$get(), $cId);            
        }
    }

    /**
     * Simple getter.
     *
     * @param  $name
     * @return
     */
    public function __get($name) {
        if (isset($this->$name)) {
            return $this->$name;
        }

        $call = 'get' . $name;
        if (method_exists($this, $call)) {
            return $this->$call();
        }
    }

    public function __call($name, $param) {


        if (preg_match('/get(\w+)/', $name, $matches)) {
            $virtualColumn = $matches[1];
            $virtualColumn = strtolower($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
            // no lcfirst in php<5.3...
            $virtualColumn[0] = strtolower($virtualColumn[0]);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        } else {
            return parent::__call($name, $virtualColumn);
        }
    }

    public function getVirtualColumn($name) {


        $name = strtolower($name);

        if (!$this->hasVirtualColumn($name)) {
            return false;
        }

        return parent::getVirtualColumn($name);
    }

    public function setVirtualColumn($name, $value) {

        $name = strtolower($name);


        parent::setVirtualColumn($name, $value);
    }

}
