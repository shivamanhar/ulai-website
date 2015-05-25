<?php

namespace Category;

/**
 * @property CI_DB_active_record $db
 */
class SFilter {

    private $ci;
    private $db;
    private $locale;
    private $model = null;
    private $sortByAdminPropVal = false;
    private static $object;

    public static function create(\SCategory $model, array $get) {

        if (!self::$object)
            self::$object = new SFilter($model, $get);

        return self::$object;
    }

    private function __construct($model, $get) {

        $this->ci = &get_instance();
        $this->db = &$this->ci->db;
        $this->locale = \MY_Controller::getCurrentLocale();
        $this->get = $get;

        if ($this->get['lp']) {
            $this->get_lp = (int) $this->get['lp'] / \Currency\Currency::create()->getRateByfilter() - 1;
        }

        if ($this->get['rp']) {
            $this->get_rp = (int) $this->get['rp'] / \Currency\Currency::create()->getRateByfilter() + 1;
        }

        $this->propGetSelect = $this->getProductIdFromPropGet();
        if (!$model) {
            return false;
        } else {
            if (in_array(get_class($model), array('SCategory', 'SBrands'))) {
                $this->model = $model;
            }
        }
    }

    /**
     * get product bt get prop request
     * @param optional (int) key unset
     * @return --
     */
    private function getProductIdFromPropGet($keyUnsey = null) {

        $resultArray = false;
        if (is_array($this->get['p'])) {
            $propertiesInGet = $this->get['p'];
            if (null != $keyUnsey) {
                unset($propertiesInGet[$keyUnsey]);
            }
            $array_products = array();
            foreach ($propertiesInGet as $pkey => $pvalue) {
                $arr_prod = array();
                foreach ($pvalue as $pk => $pv) {

                    $this->db->where('property_id', (int) $pkey);
                    $this->db->where('value', $pv);
                    $this->db->where('locale', $this->locale);

                    foreach ($this->db->distinct()->select('product_id')->get('shop_product_properties_data')->result_array() as $prod) {
                        $arr_prod[$prod['product_id']] = 1;
                    }
                }
                $array_products[] = $arr_prod;
            }
            if (count($array_products)) {
                foreach ($array_products as $key => $arr) {
                    $resultArray = (!$key) ? $arr : array_intersect_key($resultArray, $arr);
                }
            }
        }
        return $resultArray;
    }

    /**
     * filter by price object db 
     * @param --
     * @return --
     */
    private function filterProductFromPriceGet() {

        if (isset($this->get_lp) || isset($this->get_rp)) {
            if (isset($this->get_lp) && $this->get_lp > 0) {
                $this->db->where('shop_product_variants.price >= ', (int) ($this->get_lp));
            }

            if (isset($this->get_rp) && $this->get_rp > 0) {
                $this->db->where('shop_product_variants.price <= ', (int) ($this->get_rp));
            }
        }
    }

    /**
     * returns array of stdClass brands objects
     * @param SCategory $categoryModel
     * @return type
     */
    public function getBrands() {
        if (!$this->model) {
            return;
        } else {
            if (get_class($this->model)) {

                $brands = $this->db->distinct()->select('shop_brands_i18n.name, shop_brands.id')
                        ->from('shop_brands')
                        ->join('shop_products', 'shop_products.brand_id = shop_brands.id')
                        ->join('shop_product_categories', 'shop_product_categories.product_id=shop_products.id')
                        ->join('shop_brands_i18n', 'shop_brands_i18n.id=shop_brands.id')
                        ->where('shop_products.active', 1)
                        ->where('shop_product_categories.category_id', $this->model->getId())
                        ->where('shop_brands_i18n.locale', $this->locale)
                        ->order_by('shop_brands_i18n.name')
                        ->get();

                if ($brands) {
                    $brands = $brands->result();
                    $brands = $this->getProductsInBrandCount($brands);
                } else {
                    $brands = null;
                }

                return $brands;
            } else {
                return array();
            }
        }
    }

    /**
     * count products in brands
     * @param type $brands
     * @return type
     */
    private function getProductsInBrandCount($brands = array()) {
        if (is_array($brands)) {

            $productIds = array();

            $array_products = $this->propGetSelect;

            $this->db->distinct()->select('shop_products.id as id, shop_products.brand_id as brand_id')
                    ->from('shop_products')
                    ->join('shop_product_variants', 'shop_product_variants.product_id=shop_products.id')
                    ->join('shop_product_categories', 'shop_product_categories.product_id = shop_products.id')
                    ->where('shop_products.active', 1)
                    ->where('shop_product_categories.category_id', $this->model->getId())
                    ->group_by('shop_product_variants.product_id');

            $this->filterProductFromPriceGet();


            if (is_array($array_products)) {

                $product = array_keys($array_products);
                $this->db->where_in('shop_product_categories.product_id', $product);
            }

            $productSelectMain = $this->db->get()->result_array();


            if (count($productSelectMain)) {
                foreach ($productSelectMain as $p) {
                    $productIds[] = $p['brand_id'];
                }
            }

            if (count($productIds)) {
                $brandCnt = array_count_values($productIds);
            }
            foreach ($brands as $key => $brand) {
                $brands[$key]->countProducts = ($brandCnt[$brand->id]) ? $brandCnt[$brand->id] : 0;
            }
        }
        return $brands;
    }

    /**
     * returns array of stdClass properties objects
     * @param SCategory $categoryModel
     * @return type
     */
    public function getProperties() {

        if (!$this->model) {
            return;
        } else {
            // всі властивості даної категорії
            $this->db->distinct()->select('shop_product_properties_categories.property_id, shop_product_properties_i18n.name')
                    ->from('shop_product_properties_categories')
                    ->join('shop_product_properties', 'shop_product_properties_categories.property_id=shop_product_properties.id')
                    ->join('shop_product_properties_i18n', 'shop_product_properties_categories.property_id=shop_product_properties_i18n.id')
                    ->where('shop_product_properties_i18n.locale', $this->locale)
                    ->where('shop_product_properties.show_in_filter', 1)
                    ->where('shop_product_properties.active', 1)
                    ->where('shop_product_properties_categories.category_id', $this->model->getId());

            $properties = $this->db
                    ->order_by('shop_product_properties.position')
                    ->get();

            if ($properties) {
                $properties = $properties->result();
                if (is_array($properties)) {
                    foreach ($properties as $key => $item) {
                        // значення властивостей 
                        $this->db->distinct()
                                ->select('value')
                                ->from('shop_product_properties_data')
                                ->join('shop_product_categories', 'shop_product_categories.product_id=shop_product_properties_data.product_id')
                                ->join('shop_products', 'shop_product_categories.product_id=shop_products.id')
                                ->where('shop_product_properties_data.property_id', $item->property_id)
                                ->where('shop_product_properties_data.locale', $this->locale)
                                ->where("shop_product_properties_data.value <> ''")
                                ->where("shop_products.active = '1'")
                                ->where('shop_product_categories.category_id', $this->model->getId())
                                ->order_by('ABS(shop_product_properties_data.value)');
                        ;


                        $properties[$key]->possibleValues = $this->db
                                ->group_by('shop_product_properties_data.value')
                                ->get();

                        if ($properties[$key]->possibleValues) {
                            $properties[$key]->possibleValues = $properties[$key]->possibleValues->result_array();
                        } else {
                            throw new \Exception;
                        }
                    }
                }
            } else {
                throw new \Exception("Wrong query");
            }

            if ($properties) {
                $properties = $this->getProductsInProperties($properties);
                if ($this->sortByAdminPropVal)
                    $properties = $this->setPropValuePos($properties);
            }
            return $properties;
        }
    }

    /**
     * count propucts in each property
     * @param type $properties
     * @return type
     */
    private function getProductsInProperties($properties = array()) {

        $this->db->distinct()
                ->select('shop_products.id as id, shop_product_properties_data.value as val, shop_product_properties_data.property_id as propid')
                ->from('shop_products')
                ->join('shop_product_categories', 'shop_product_categories.product_id = shop_products.id')
                ->join('shop_brands', 'shop_products.brand_id = shop_brands.id', 'left')
                ->join('shop_product_variants', 'shop_product_variants.product_id = shop_products.id')
                ->join('shop_product_properties_data', "shop_product_properties_data.product_id = shop_product_categories.product_id and shop_product_properties_data.locale = '" . $this->locale . "'");

        $this->db->where('shop_product_categories.category_id', $this->model->getId());

        $this->filterProductFromPriceGet();

        if (isset($this->get['brand']) && is_array($this->get['brand'])) {
            $brands_ids = array();
            foreach ($this->get['brand'] as $brandId) {
                $brands_ids[] = $brandId;
            }
            $this->db->where_in('shop_products.brand_id', $brands_ids);
        }

        $this->db->where('shop_products.active', 1);


        $productSelectMain = $this->db->get()->result_array();


        foreach ($properties as $key => $item) {
            $array_products = $this->getProductIdFromPropGet($item->property_id);
            $propArr = array();
            if (count($productSelectMain)) {
                foreach ($productSelectMain as $prod) {
                    if (is_array($array_products)) {
                        if (array_key_exists($prod['id'], $array_products)) {
                            $propArr[] = $prod['propid'] . '_' . $prod['val'];
                        }
                    } else {
                        $propArr[] = $prod['propid'] . '_' . $prod['val'];
                    }
                }
            }
            $propCnt = array_count_values($propArr);
            foreach ($properties[$key]->possibleValues as $k => $v) {
                $properties[$key]->possibleValues[$k]['count'] = ($propCnt[$item->property_id . '_' . $v['value']]) ? $propCnt[$item->property_id . '_' . $v['value']] : 0;
                $properties[$key]->productsCount += $properties[$key]->possibleValues[$k]['count'];
            }
        }


        return $properties;
    }

    /**
     * for sorting
     */
    private function setPropValuePos($properties) {
        $this->db->cache_on();

        $data = $this->db->select('*, shop_product_properties.id as pid')
                ->from('shop_product_properties')
                ->join('shop_product_properties_i18n', 'shop_product_properties_i18n.id = shop_product_properties.id')
                ->where('shop_product_properties_i18n.locale', $this->locale)
                ->get();

        $prop_for_sync = $data->result_array();
        $this->db->cache_off();

        foreach ($properties as $key => $prop) {
            foreach ($prop_for_sync as $p_for_sync) {
                if ($p_for_sync['id'] == $prop->property_id) {
                    $data_origin = $prop->possibleValues;
                    $data_sync = unserialize($p_for_sync['data']);
                    $properties[$key]->possibleValues = $this->syncDataPos($data_origin, $data_sync);
                }
            }
        }

        return $properties;
    }

    /**
     * for sorting
     */
    private function syncDataPos($data_origin, $data_sync) {

        $arr_aux = array();
        foreach ($data_sync as $d_s) {
            foreach ($data_origin as $d_o) {
                if ($d_s == $d_o['value'])
                    $arr_aux[] = $d_o;
            }
        }
        return $arr_aux;
    }

    /**
     * returns array with min and max price
     */
    public function getPricerange() {
        if (!$this->model) {
            return;
        } else {

            $this->db->select('MIN(shop_product_variants.price) AS minCost, MAX(shop_product_variants.price) AS maxCost')
                    ->from('shop_product_variants')
                    ->join('shop_products', 'shop_product_variants.product_id=shop_products.id')
                    ->join('shop_product_categories', 'shop_product_categories.product_id = shop_products.id');


            $priceRange = $this->db->where('shop_product_categories.category_id', $this->model->getId())
                    ->get();

            if ($priceRange) {
                $priceRange = $priceRange->result_array();
                $priceRange = $priceRange[0];
                $priceRange['minCost'] = (int) \Currency\Currency::create()->convert($priceRange['minCost']);
                $priceRange['maxCost'] = (int) \Currency\Currency::create()->convert($priceRange['maxCost']);
            } else {
                throw new \Exception;
            }

            return $priceRange;
        }
    }

    /**
     *
     * @param SProductsQuery $products
     * @return type
     * for propel product query object filtration by price
     *
     */
    public function makePriceFilter(\SProductsQuery $products) {
        if (isset($this->get_lp)) {
            $products = $products->where('FLOOR(ProductVariant.Price) >= ?', (int) $this->get_lp);
        }
        if (isset($this->get_rp)) {
            $products = $products->where('FLOOR(ProductVariant.Price) <= ?', (int) $this->get_rp);
        }

        return $products;
    }

    /**
     * for propel product query object filtration by brands
     * @param SProductsQuery $products
     * @return type
     */
    public function makeBrandsFilter(\SProductsQuery $products) {
        if (isset($this->get['brand']) && !empty($this->get['brand'])) {
            $products = $products->filterByBrandId($this->get['brand']);
        }
        return $products;
    }

    /**
     * for propel product query object filtration by properties
     * @param SProductsQuery $products
     * @return type
     */
    public function makePropertiesFilter(\SProductsQuery $products) {

        $arr_product = $this->propGetSelect;
        if (is_array($arr_product)) {
            $p = array_keys($arr_product);
            $products = $products->filterById($p);
        }

        return $products;
    }

    /**
     * to prevent setting any other variables in get array
     * @param ---
     */
    public function filterGet() {
        $allowedKeys = $this->ci->config->load('filter');

        foreach (array_keys($this->get) as $key) {
            if (!in_array($key, $allowedKeys)) {
                unset($this->get[$key]);
            }
        }
    }

}
