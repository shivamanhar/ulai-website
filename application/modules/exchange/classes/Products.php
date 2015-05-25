<?php

namespace exchange\classes;

/**
 *
 * @author kolia
 */
class Products extends ExchangeBase {

    /**
     * Path of folder where xml and images stored
     * @var string
     */
    protected $tempDir;

    /**
     *
     * @var DataCollector 
     */
    protected $insertCollector;

    /**
     *
     * @var DataCollector 
     */
    protected $updateCollector;

    /**
     * If product have images, then all 
     * his old images need to be deleted
     * @var array
     */
    protected $imagesToDelete = array();

    /**
     * @var array
     */
    protected $imagesToResize = array();

    /**
     * @var array
     */
    protected $imagesToResizeAdditional = array();
    protected $runResize = FALSE;

    /**
     *
     * @var array 
     */
    protected $productPropertiesCategories = array();

    /**
     *
     * @var array 
     */
    protected $i18nExisting = array();
    // compare data
    protected $compare_exIds = array();
    protected $compare_urls = array();
    protected $compare_properties = array();

    /**
     * If products have 'ХарактеристикиТовара' run fix
     * @var bool
     */
    protected $runVariantsFix = false;
    protected $productss;

    /**
     * In the xml there can be two diffrent products with same names, this array
     * gathers just created product urls to prevent equal addresses
     * @var array
     */
    protected $productsNewUrls = array();

    protected function import_() {
        $this->insertCollector = new DataCollector;
        $this->updateCollector = new DataCollector;

        $this->getCompareData();

        $this->processProducts1();
        $this->insert1();
        $this->processProducts23_Insert23();
        $this->update();
        $this->setAdditionalCats();
        $this->run_resize();        
    }

    /**
     * Set shop categories for products
     * @throws Exception
     */
    public function setAdditionalCats() {
        foreach ($this->products as $products) {
            $ids[] = $products['id'];
        }

        $products = $this->db
                ->select('shop_products.category_id, shop_products.id, shop_category.full_path_ids, shop_category.parent_id')
                ->join('shop_category', 'shop_category.id = shop_products.category_id')
                ->where_in('shop_products.id', $ids)
                ->get('shop_products')
                ->result();

        $this->db
                ->where_in('product_id', $ids)
                ->delete('shop_product_categories');
        $i = 0;
        foreach ($products as $product) {
            foreach (unserialize($product->full_path_ids) as $fpi) {
                $instert[$i]['category_id'] = $fpi;
                $instert[$i]['product_id'] = $product->id;
                $i++;
            }
            if (!in_array($product->parent_id, unserialize($product->full_path_ids))) {
                $i++;
                $instert[$i]['category_id'] = $product->parent_id;
                $instert[$i]['product_id'] = $product->id;
            }
            if (!in_array($product->category_id, unserialize($product->full_path_ids))) {
                $i++;
                $instert[$i]['category_id'] = $product->category_id;
                $instert[$i]['product_id'] = $product->id;
            }
            $i++;
        }
        $this->db->insert_batch('shop_product_categories', $instert);
    }

    /**
     * Setting temporary folder with import data. Mantadory!
     * @param string $tempDir
     */
    public function setTempDir($tempDir) {
        $this->tempDir = $tempDir;
        return $this;
    }

    /**
     * Getting from base data of product for fast compare (external_ids, urls...)
     * @param int $type if empty = all, 
     *  1 - only external_ids, 
     *  2 - only urls, 
     *  3 - only properties
     */
    protected function getCompareData($type = NULL) {
        foreach ($this->products as $product) {
            // external ids of products
            if (!empty($product['external_id']) & ($type == NULL || (int) $type == 1)) {
                $this->compare_exIds[$product['external_id']] = $product['id'];
            }
            if ($type == NULL || (int) $type == 2) {
                $this->compare_urls[$product['url']] = $product['external_id'];
            }
        }
        if ($type == NULL || (int) $type == 3) {
            foreach ($this->properties as $property) {
                if (!empty($property['external_id']))
                    $this->compare_properties[$property['external_id']] = $property;
            }
        }
    }

    protected function getUrls() {
        $productExIds = array();
        foreach ($this->products as $product) {
            if (!empty($product['external_id'])) {
                $productExIds[$product['external_id']] = $product['id'];
            }
        }
        return $productExIds;
    }

    /**
     * Gather data for tables:
     *  - `shop_products` (data will be ready)
     *  - `shop_products_i18n` (after `shop_products`)
     *  - `shop_product_variants` (after `shop_products`)
     *  - `shop_product_variants_i18n` (after `shop_product_variants`) 
     *  - `shop_products_categories` (after `shop_products`) 
     *  - `shop_product_images` (after `shop_products`)
     * 
     *  P.S. For updating all data will be ready immediately, inserting need depends on the order
     * 
     */
    protected function processProducts1() {
        $propertiesDataUpdate = array();
        $productPropertiesDataToDelete = array();

        // for variants
        $productsUniqueExIds = array();

        // passing each product
        foreach ($this->importData as $product) {
            if (FALSE !== strpos((string) $product->Ид, '#') && isset($product->ХарактеристикиТовара)) { // this is variant of product
                $exId = array_shift(explode('#', (string) $product->Ид)); // getting product id
                $variantExId = (string) $product->Ид;
            } else {
                $exId = (string) $product->Ид;
                $variantExId = NULL;
            }

            // GETTING ALL DATA
            list($products, $i18n) = $this->pass1Helper_getProductData($product, $exId);

            list($variant, $variantI18n) = $this->pass1Helper_getVariantData($product);

            if (NULL != $categoryId = $this->pass1Helper_getCadegoryData($product)) {
                $products['category_id'] = $categoryId;
            }
            list($additionalImages, $mainImage) = $this->pass1Helper_getImagesData($product, $exId);

            $this->imagesToResize[] = $mainImage;
            $this->imagesToResizeAdditional[] = $additionalImages['image_name'];

            if ($mainImage != NULL) {
                $variant['mainImage'] = $mainImage;
            } else {
                $variant['mainImage'] = '';
            }

            list($shopProductPropertiesData, $products['brand_id']) = $this->pass1Helper_getPropertiesData($product, $categoryId);

            $url = translit_url((string) $product->Наименование);

            // splitting on new & existing products (by external_id)
            if (!isset($this->compare_exIds[$products['external_id']])) { // NEW
                // default variants values (without `product_id`)
                if (!is_null($variantExId)) { // this is variant of product
                    $this->insertCollector->addData('shop_product_variants', $variant, $variantExId);
                    $this->insertCollector->addData('shop_product_variants_i18n', $variantI18n, $variantExId);
                    if (!isset($productsUniqueExIds[$exId])) {
                        $productsUniqueExIds[$exId] = 0;
                    } else {
                        $this->insertCollector->newPass();
                        $this->updateCollector->newPass();
                        continue;
                    }
                } else {
                    $this->insertCollector->addData('shop_product_variants', $variant, $exId);
                    $this->insertCollector->addData('shop_product_variants_i18n', $variantI18n, $exId);
                }

                if (isset($this->compare_urls[$url])) {
                    if ($this->compare_urls[$url] != $exId) { // add some number to url
                        $i = 1;
                        $url_ = $url;
                        while (key_exists($url, $this->compare_urls)) {
                            $url = $url_ . ++$i;
                        }
                    }
                }

                $products['url'] = $url;
              
                $this->compare_urls[$url] = $exId;

                $this->insertCollector->addData('shop_products', $products, $exId);
                $this->insertCollector->addData('shop_products_i18n', $i18n, $exId);

                $this->insertCollector->addData('shop_product_categories', array('category_id' => $products['category_id']), $exId);
                foreach ($shopProductPropertiesData as $propertyData) {
                    $this->insertCollector->updateData('shop_product_properties_data', $propertyData, $exId);
                }
                if ($additionalImages != NULL) {
                    $this->insertCollector->addData('shop_product_images', $additionalImages, $exId);
                }
            } else { // EXISTING
                $productId = $this->compare_exIds[$exId];

                if (isset($this->variantImages[$exId]) & empty($variant['mainImage'])) {
                    $variant['mainImage'] = $this->variantImages[$exId];
                }

                // to not drop prices on update
                unset($variant['price_in_main']);
                unset($variant['price']);

                if (!is_null($variantExId)) { // this is variant of product
                    $this->updateCollector->addData('shop_product_variants', array_merge($variant, array('product_id' => $productId)));
                    $this->updateCollector->addData('shop_product_variants_i18n', $variantI18n, $variantExId);
                    if (!isset($productsUniqueExIds[$exId])) {
                        $productsUniqueExIds[$exId] = 0;
                    } else {
                        $this->insertCollector->newPass();
                        $this->updateCollector->newPass();
                        continue;
                    }
                } else {
                    $this->updateCollector->addData('shop_product_variants', array_merge($variant, array('product_id' => $productId)));
                    $this->updateCollector->addData('shop_product_variants_i18n', $variantI18n, $exId);
                }

                if (isset($products['category_id'])) { // will be updated by product_id
                    $this->updateCollector->addData('shop_product_categories', array(
                        'product_id' => $productId,
                        'category_id' => $products['category_id'],
                    ));
                }
                $this->updateCollector->addData('shop_products', array_merge($products, array('id' => $productId, 'url' => $url)));
                $this->updateCollector->addData('shop_products_i18n', array_merge($i18n, array('id' => $productId)));

                foreach ($shopProductPropertiesData as $propertyData) {
                    $propertiesDataUpdate[] = array_merge($propertyData, array('product_id' => $productId));
                }
                $productPropertiesDataToDelete[] = $productId;
                if ($additionalImages != NULL) {
                    $this->updateCollector->addData('shop_product_images', array_merge($additionalImages, array('product_id' => $productId)));
                }
            }

            $this->insertCollector->newPass();
            $this->updateCollector->newPass();
        }

        $this->db
                ->where_in('product_id', $productPropertiesDataToDelete)
                ->delete('shop_product_properties_data');

        $this->insertBatch('shop_product_properties_data', $propertiesDataUpdate);
    }

    /**
     * Inserting data into `shop_products`
     */
    protected function insert1() {
        $this->insertBatch('shop_products', $this->insertCollector->getData('shop_products'));
        $this->dataLoad->getNewData('products');

        // properties-categories relations
        if (count($this->productPropertiesCategories) > 0) {
            $epc = $this->db->get('shop_product_properties_categories')->result_array();
            foreach ($this->productPropertiesCategories as $key => $newRowData) {
                $newRowIsReallyNew = TRUE;
                foreach ($epc as $rowData) {
                    if (
                            $newRowData['property_id'] == $rowData['property_id'] &
                            $newRowData['category_id'] == $rowData['category_id']
                    ) {
                        unset($this->productPropertiesCategories[$key]);
                        $newRowIsReallyNew = FALSE;
                        break;
                    }
                }
                if ($newRowIsReallyNew == FALSE) {
                    continue;
                }
            }
            $this->insertBatch('shop_product_properties_categories', $this->productPropertiesCategories);
        }
    }

    /**
     * Filling with product_id tables that need it, and inserting into other tables
     */
    protected function processProducts23_Insert23() {
        // process 2 (adding product_id to tables data)
        $products = &$this->insertCollector->getData('shop_products');
        $productsI18n = &$this->insertCollector->getData('shop_products_i18n');
        $variants = &$this->insertCollector->getData('shop_product_variants');
        $propertiesData = &$this->insertCollector->getData('shop_product_properties_data');
        $images = &$this->insertCollector->getData('shop_product_images');
        $productCategories = &$this->insertCollector->getData('shop_product_categories');
        $imagesToDelete = array();
        $propertiesData_ = array();

        foreach ($this->productIds as $externalId => $productId) {
            if (FALSE == isset($products[$externalId])) {
                continue;
            }
            $productsI18n[$externalId]['id'] = $productId;
            if (isset($propertiesData[$externalId])) {
                foreach ($propertiesData[$externalId] as $oneProductPropData) {
                    $propertiesData_[] = array_merge($oneProductPropData, array('product_id' => $productId));
                }
            }
            if (isset($images[$externalId])) {
                $images[$externalId]['product_id'] = $productId;
            }
            if (isset($this->imagesToDelete[$externalId])) {
                $imagesToDelete[] = $productId;
            }
            if (isset($productCategories[$externalId])) {
                $productCategories[$externalId]['product_id'] = $productId;
                if (FALSE == $this->isProductCategoriesRowNew($productCategories[$externalId])) {
                    unset($productCategories[$externalId]);
                }
            }
        }
        $this->insertCollector->unsetData('shop_product_properties_data');
        // insert 2 (inserting those which where needed product_id)
        $this->insertBatch('shop_products_i18n', $productsI18n);

        foreach ($variants as $variantExId => $variantData) {
            $productExId = array_shift(explode('#', $variantExId));
            $variants[$variantExId]['product_id'] = $this->productIds[$productExId];
        }

        $this->insertBatch('shop_product_variants', $variants);

        // adding shop_product_properties_data and shop_product_properties_data_i18n is not so ordinary...
        if (count($propertiesData_) > 0) {
            $existingPropertiesData = $this->db
                    ->select('id')
                    ->get('shop_product_properties_data')
                    ->result_array();
            array_walk($existingPropertiesData, function(&$item, $key) {
                $item = $item['id'];
            });

            $this->insertBatch('shop_product_properties_data', $propertiesData_);

            $this->db->select('id, value, locale');
            if (count($existingPropertiesData) > 0) {
                $this->db->where_not_in('id', $existingPropertiesData);
            }
            $propDataForI18n = $this->db->get('shop_product_properties_data')->result_array();

            if (count($propDataForI18n) > 0) {
                $this->insertBatch('shop_product_properties_data_i18n', $propDataForI18n);
            }
        }

        // inserting shop_product_categories
        $this->insertBatch('shop_product_categories', $productCategories);

        //process3 (variants)
        $variantsI18n = &$this->insertCollector->getData('shop_product_variants_i18n');

        $variantsIds = $this->dataLoad->getNewData('variantsIds');
        foreach ($variantsIds as $externalId => $variantId) {
            if (FALSE == isset($variantsI18n[$externalId])) {
                continue;
            }
            $variantsI18n[$externalId]['id'] = $variantId;
        }

        // insert 3
        $this->insertBatch('shop_product_variants_i18n', $variantsI18n);

        // deleting additional images, inserting new
        if ($imagesToDelete) {
            $this->db->where_in('product_id', $imagesToDelete)->delete('shop_product_images');
        }
        $this->insertBatch('shop_product_images', $images);
    }

    /**
     * Update all 
     */
    protected function update() {
        // update has only two "passes" - as we already got product_id
        $this->updateFromCollector('shop_products', 'id');
        $this->updateFromCollector('shop_product_categories', 'product_id');
        $this->updateFromCollector('shop_products_i18n', 'id');
        //$this->updateFromCollector('shop_product_properties_data', 'product_id');
        $this->updateFromCollector('shop_product_images', 'product_id');
        $this->updateFromCollector('shop_product_variants', 'product_id');

        // get variants ids, and update variants_18n
        $variantsI18n = &$this->updateCollector->getData('shop_product_variants_i18n');

        $this->dataLoad->getNewData('variantsIds');
        foreach ($variantsI18n as $exId => $variantI18n) {
            $variantsI18n[$exId]['id'] = $this->variantsIds[$exId];
        }

        $this->updateBatch('shop_product_variants_i18n', $variantsI18n, 'id');
    }

    /**
     * Helper-method for updating
     * @param string $tableName
     * @param string $compareField
     */
    protected function updateFromCollector($tableName, $compareField) {
        $this->updateBatch($tableName, $this->updateCollector->getData($tableName), $compareField);
    }

    // ------------------------------ HELPERS ------------------------------

    /**
     * Method-helper for simplify processProducts1 method
     * @param \SimpleXMLElement $product
     * @return array
     */
    protected function pass1Helper_getProductData(\SimpleXMLElement $product, $exId) {
        $products = array(
            'external_id' => $exId,
            'active' => (string) $product->Статус == 'Удален' ? 0 : 1,
        );
        $i18n = array(
            'locale' => $this->locale,
            'name' => (string) $product->Наименование,
            'short_description' => (string) $product->Описание,
            'full_description' => (string) $product->Описание,
        );

        return array($products, $i18n);
    }

    /**
     * Method-helper for simplify processProducts1 method
     * @param \SimpleXMLElement $product
     * @return array
     */
    protected function pass1Helper_getVariantData(\SimpleXMLElement $product) {
        $variant = array(
            'external_id' => (string) $product->Ид,
            'number' => (string) $product->Артикул,
            'currency' => $this->mainCurrencyId
        );

        //$name = (string) $product->Наименование;
        $name = '';
        if (isset($product->ХарактеристикиТовара)) {
            foreach ($product->ХарактеристикиТовара->ХарактеристикаТовара as $value) {
                $name .= ' ' . (string) $value->Значение;
            }
        }

        $variantI18n = array(
            'locale' => $this->locale,
            'name' => trim($name),
        );

        $defaultVariantsValues = array('price' => '0.00000', 'stock' => 0, 'position' => 0, 'price_in_main' => '0.00000');
        return array(array_merge($variant, $defaultVariantsValues), $variantI18n);
    }

    /**
     * Method-helper for simplify processProducts1 method
     * @param \SimpleXMLElement $product
     * @return array
     */
    protected function pass1Helper_getCadegoryData(\SimpleXMLElement $product) {
        $categoryId = NULL;
        if (isset($product->Группы)) {
            $categoryExId = (string) $product->Группы->Ид;
            $categoryId = Categories::getInstance()->categoryExists2($categoryExId, TRUE);
            if (FALSE == $categoryId) {
                throw new \Exception('Error! Product category not found in table `shop_category` ');
            }
        }
        return $categoryId;
    }

    /**
     * Method-helper for simplify processProducts1 method
     * @param \SimpleXMLElement $product
     * @return array
     */
    protected function pass1Helper_getImagesData(\SimpleXMLElement $product, $exId) {
        //$exId = (string) $product->Ид;

        $additionalImages = NULL;
        $mainImage = NULL;

        if (count($product->Картинка) > 1) {
            $this->imagesToDelete[$exId] = NULL;
        }
        $i = 0;
        foreach ($product->Картинка as $image) {
            $path = (string) $image;
            $fileName = pathinfo($path, PATHINFO_BASENAME);
            if ($i == 0) { // main image
                if (file_exists($this->tempDir . $path)) {
                    $copied = copy($this->tempDir . $path, './uploads/shop/products/origin/' . $fileName);
                    if ($copied != FALSE) {
                        $mainImage = $fileName;
                    }
                }
            } else { // rest of images will be an additional
                if (file_exists($this->tempDir . $path)) {
                    $copied = copy($this->tempDir . $path, './uploads/shop/products/origin/additional/' . $fileName);
                    if ($copied != FALSE) {
                        $additionalImages = array(
                            'position' => $i - 1,
                            'image_name' => $fileName
                        );
                    }
                }
            }
            $i++;
        }
        return array($additionalImages, $mainImage);
    }

    /**
     * Method-helper for simplify processProducts1 method
     * @param \SimpleXMLElement $product
     * @return array
     */
    protected function pass1Helper_getPropertiesData(\SimpleXMLElement $product, $categoryId) {
        $brandIdentif = Properties::getInstance()->getBrandIdentif();
        $brandId = '';

        $shopProductPropertiesData = array();
        // processing properties of product
        if (isset($product->ЗначенияСвойств)) {
            foreach ($product->ЗначенияСвойств->ЗначенияСвойства as $property) {
                $propertyValue = (string) $property->Значение;
                if (empty($propertyValue)) {
                    continue;
                }
                // check for "brand"
                $propertyExId = (string) $property->Ид;
                if ($propertyExId == $brandIdentif) {
                    $brandId = Properties::getInstance()->getBrandIdByExId($propertyValue);
                    continue;
                }

                if (!isset($this->compare_properties[$propertyExId])) {
                    continue;
                }

                $propertyId = $this->compare_properties[$propertyExId]['id'];

                // if property is multiple, then correting value

                if (Properties::getInstance()->dictionaryProperties[$propertyExId]) {
                    $propertyValue = Properties::getInstance()->dictionaryProperties[$propertyExId][$propertyValue];
                }

                $shopProductPropertiesData[] = array(
                    'property_id' => $propertyId,
                    'value' => $propertyValue,
                    'locale' => $this->locale,
                );

                if ($categoryId != NULL) {
                    $newRow = TRUE;
                    foreach ($this->productPropertiesCategories as $row) {
                        if ($row['property_id'] == $propertyId & $row['category_id'] == $categoryId) {
                            $newRow = FALSE;
                            break;
                        }
                    }
                    if ($newRow == TRUE) {
                        $this->productPropertiesCategories[] = array('property_id' => $propertyId, 'category_id' => $categoryId); // TODO: то тоже тре бде потім розібрати
                    }
                }
            }
        }
        return array($shopProductPropertiesData, $brandId);
    }

    // ----------------------- end of HELPERS ------------------------------
    private function run_resize($run_resize = FALSE) {
        if ($this->runResize) {
            \MediaManager\Image::create()
                    ->resizeByName($this->imagesToResize)
                    ->resizeByNameAdditional(array_unique($this->imagesToResizeAdditional));
        }
    }

    public function setResize($run_resize = FALSE) {
        $this->runResize = $run_resize;
        return $this;
    }

    /**
     * 
     */
    protected function addProductsToUpperCategories() {
        $products = $this->db->select('shop_products.id, shop_category.full_path_ids')
                ->join('shop_category', 'shop_category.id = shop_products.category_id')
                ->get('shop_products')
                ->result();

        $insertData = array();
        foreach ($products as $product) {
            $path = unserialize($product->full_path_ids);
            foreach ($path as $fpi) {
                $newData = array(
                    'category_id' => $fpi,
                    'product_id' => $product->id
                );
                if ($this->isProductCategoriesRowNew($newData) == FALSE) {
                    continue;
                }
                $insertData[] = $newData;
            }
        }
        $this->insertBatch('shop_product_categories', $insertData);
    }

    /**
     * 
     * @param array $newRowData
     * @return boolean
     */
    protected function isProductCategoriesRowNew(array $newRowData) {
        if (!isset($this->existingRows)) {
            $this->existingRows = $this->db->get('shop_product_categories')->result_array();
        }

        foreach ($this->existingRows as $existingRowData) {
            if (
                    $existingRowData['product_id'] == $newRowData['product_id'] &
                    $existingRowData['category_id'] == $newRowData['category_id']
            ) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * 
     * @param string $productName
     * @return string
     */
    private function getProductUrl($productName) {
        $productNameTemp = $productName;
        $i = 1;
        do {
            $url = translit_url($productName);
            $productName = $productNameTemp . $i++;
        } while (isset($this->productsNewUrls[$url]));
        $this->productsNewUrls[$url] = 1;
        return $url;
    }

}
