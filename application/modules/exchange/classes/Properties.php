<?php

namespace exchange\classes;

/**
 * 
 *
 * @author kolia
 */
class Properties extends ExchangeBase {

    const PROPTYPE_NUM = 0;
    const PROPTYPE_SPR = 1;

    /**
     * External ids of new properties
     * @var array 
     */
    protected $new = array();

    /**
     * External ids of existing properties
     * @var array 
     */
    protected $existing = array();

    /**
     *
     * @var array
     */
    protected $propertiesData = array();

    /**
     * For the properties with type "Справочник"
     * @var array 
     */
    public $dictionaryProperties = array();

    /**
     * 
     * @var string
     */
    protected $brandIdentif = NULL;

    /**
     *
     * @var array (property_external_id => id)
     */
    protected $brands = array();

    /**
     * 
     */
    protected function import_() {

        // preparing data array for insert, spliting on new and existing properties

        $this->processProperties();

        if (count($this->new) > 0) {
            $this->insert();
        }

        if (count($this->existing) > 0) {
            $this->update();
        }

        if (count($this->brands) > 0) {
            $this->insertBrands();
        }

        $this->dataLoad->getNewData('properties');
    }

    public function setBrandIdentif($brandIdentif) {
        $this->brandIdentif = $brandIdentif;
        return $this;
    }

    public function getBrandIdByExId($externalId = NULL) {
        if ($externalId == NULL) {
            return $this->brands;
        }

        if (key_exists($externalId, $this->brands)) {
            return $this->brands[$externalId];
        }

        return FALSE;
    }

    /**
     * Returns property identificator of brand
     * @return string|NULL
     */
    public function getBrandIdentif() {
        return $this->brandIdentif;
    }

    /**
     * Parsing properties. Separation on new and existing. 
     * Preparing arrays (insert & update) for db
     */
    protected function processProperties() {
        foreach ($this->importData as $property) {
            $propertyData = array();
            $externalId = (string) $property->Ид;
            $name = (string) $property->Наименование;

            if ($name == $this->brandIdentif & $this->brandIdentif !== NULL) {
                $this->brandIdentif = $externalId;
            }

            $propertyData = array(
                'external_id' => $externalId,
                // default property values
                'show_in_compare' => 0,
                'show_on_site' => 1,
                'show_in_filter' => 0,
            );

            $this->propertiesData[$externalId]['name'] = $name;

            $propertyData['csv_name'] = str_replace(array("-", "_", "'"), '', translit_url($property->Наименование));

            // type ("Справочник"|"Число")
            $type = (string) $property->ТипЗначений == 'Справочник' ? self::PROPTYPE_SPR : self::PROPTYPE_NUM;
            $this->propertiesData[$externalId]['type'] = $type;

            if ($type == self::PROPTYPE_SPR) {
                // getting all possible values
                $values = array();
                foreach ($property->ВариантыЗначений->Справочник as $propValue) {
                    $values[(string) $propValue->ИдЗначения] = (string) $propValue->Значение;
                }
                $this->dictionaryProperties[$externalId] = $values;

                if ($this->brandIdentif == $externalId) {
                    $this->brands = $values;
                }
            }

            // main_property
            $propertyData['main_property'] = (string) $property->Обязательное == 'true' ? 1 : 0;

            // cheking if property is "multivalue"
            if ((string) $property->Множественное == 'true' || $type == self::PROPTYPE_SPR) {
                $propertyData['multiple'] = 1;
            } else {
                $propertyData['multiple'] = 0;
            }

            // status of property (active or disabled)
            $active = (string) $property->ИспользованиеСвойства == 'true' ? TRUE : FALSE;
            if ($active == TRUE || count($property->ИспользованиеСвойства) == 0) {
                $propertyData['active'] = 1;
            } else {
                $propertyData['active'] = 0;
            }

            // separation on new and existing 
            if (FALSE == $this->propertyExists($externalId)) {
                $this->new[$externalId] = $propertyData;
            } else {
                $this->existing[$externalId] = $propertyData;
            }

          
        }
    }

    /**
     * 
     */
    protected function insert() {
        $this->insertBatch('shop_product_properties', $this->new);
        // geting updated data from DB
        $this->dataLoad->getNewData('properties');

        // preparing data for `i18n` and `mod_exchange`
        $i18n = array();
        $modExchange = array();
        foreach ($this->properties as $propertyData) {
            $exId = $propertyData['external_id'];

            if (key_exists($exId, $this->new)) {
                $arr = array();
                if (!empty($this->dictionaryProperties[$exId])) {
                    foreach ($this->dictionaryProperties[$exId] as $value) {
                        $arr[] = trim($value);
                    }
                    $data = serialize($arr);
                } else {
                    $data = '';
                }

                $i18n[] = array(
                    'id' => $propertyData['id'],
                    'name' => $this->propertiesData[$exId]['name'],
                    'locale' => $this->locale,
                    'data' => $data,
                );

                // gathering property possible values, if type = "Справочник"
                if ($this->propertiesData[$exId]['type'] == self::PROPTYPE_SPR) {
                    foreach ($this->dictionaryProperties[$exId] as $valueExternalId => $value) {
                        $modExchange[] = array(
                            'external_id' => $valueExternalId,
                            'property_id' => $propertyData['id'],
                            'value' => $value,
                        );
                    }
                }
            }
        }

        $this->insertBatch('shop_product_properties_i18n', $i18n);
    }

    /**
     * Inserting new brands,
     * forming array with all new brands
     */
    protected function insertBrands() {
        // getting existing brands
        $result = $this->db
                ->select(array('id', 'name'))
                ->get('shop_brands_i18n')
                ->result_array();

        $existingBrands = array();
        foreach ($result as $brandData) {
            $existingBrands[strtolower($brandData['name'])] = $brandData['id'];
        }

        // inserting new brands
        $newBrands = array();
        $referensForI18n = array();
        $existing_ = array();
        foreach ($this->brands as $externalId => $brandName) {
            $name_ = strtolower($brandName);
            if (key_exists($name_, $existingBrands)) { // brand exist
                $this->brands[$externalId] = $existingBrands[$name_];
            } else {
                $url = translit_url($brandName);
                $referensForI18n[$url] = $externalId;
                $newBrands[] = array('url' => $url);
            }
        }

        // those witch will be needed for products
        if (count($newBrands) > 0) {
            $this->insertBatch('shop_brands', $newBrands);
            $result = $this->db
                    ->select(array('id', 'url'))
                    ->get('shop_brands')
                    ->result_array();

            $newBrandsI18n = array();
            foreach ($result as $brandData) {
                if (key_exists($brandData['url'], $referensForI18n)) {
                    $newBrandsI18n[] = array(
                        'id' => $brandData['id'],
                        'name' => $this->brands[$referensForI18n[$brandData['url']]],
                        'locale' => $this->locale
                    );
                    $this->brands[$referensForI18n[$brandData['url']]] = $brandData['id'];
                }
            }

            $this->insertBatch('shop_brands_i18n', $newBrandsI18n);
        }
    }

    /**
     * 
     */
    protected function update() {
        $this->updateBatch('shop_product_properties', $this->existing, 'external_id');
        // preparing data for `i18n` and `mod_exchange`
        $i18n = array();
        $modExchange = array();
        foreach ($this->properties as $propertyData) {
            $exId = $propertyData['external_id'];
            if (key_exists($exId, $this->existing)) {
                $arr = array();
                if (!empty($this->dictionaryProperties[$exId])) {
                    foreach ($this->dictionaryProperties[$exId] as $value) {
                        $arr[] = trim($value);
                    }
                    $data = serialize($arr);
                } else {
                    $data = '';
                }

                $i18n[] = array(
                    'id' => $propertyData['id'],
                    'name' => $this->propertiesData[$exId]['name'],
                    'locale' => $this->locale,
                    'data' => $data,
                );

                // gathering property possible values, if type = "Справочник"
                if ($this->propertiesData[$exId]['type'] == self::PROPTYPE_SPR) {
                    foreach ($this->dictionaryProperties[$exId] as $valueExternalId => $value) {
                        $modExchange[] = array(
                            'external_id' => $valueExternalId,
                            'property_id' => $propertyData['id'],
                            'value' => $value,
                        );
                    }
                }
            }
        }
        $this->updateBatch('shop_product_properties_i18n', $i18n, 'id');
        //$this->updateBatch('mod_exchange', $modExchange, 'external_id');
    }

    /**
     * Checks if property exists by external id
     * @param string $externalId
     * @return boolean 
     */
    protected function propertyExists($externalId) {
        foreach ($this->properties as $propertyData) {
            if ($propertyData['external_id'] == $externalId)
                return TRUE;
        }
        return FALSE;
    }

}
