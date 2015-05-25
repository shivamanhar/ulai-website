<?php 

 use Base\SCategory as BaseSCategory;
 use Propel\Runtime\ActiveQuery\Criteria;
 use Map\SCategoryTableMap;
 use Map\SCategoryI18nTableMap;

/**
 * Skeleton subclass for representing a row from the 'shop_category' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SCategory extends BaseSCategory {
    
    public function __construct() {
        parent::__construct();
        $this->currentLocale = \MY_Controller::getCurrentLocale();
    }

    public function attributeLabels() {
        return array(
            'Id' => ShopCore::t('Id'),
            'Name' => lang('Title', 'admin'),
            'Url' => ShopCore::t('URL'),
            'Description' => lang('Description', 'admin'),
            'H1' => ShopCore::t('H1'),
            'MetaDesc' => ShopCore::t('Meta Description'),
            'MetaKeywords' => ShopCore::t('Meta Keywords'),
            'MetaTitle' => ShopCore::t('Meta Title'),
            'ParentId' => lang('Parent', 'admin'),
            'Active' => lang('Active', 'admin'),
            'tpl' => lang('Category template', 'admin'),
            'order_method' => lang('Sorting method by default', 'admin')
        );
    }

    /**
     * Validation rules
     *
     * @access public
     * @return array
     */
    public function rules() {
        return array(
            array(
                'field' => 'Name',
                'label' => $this->getLabel('Name'),
                'rules' => 'required|max_length[255]'
            ),
        );
    }

    /**
     * preSave hook.
     *
     * @access public
     * @return bool
     */
    public function preSave() {
        /**
         *  Translit category name to url if url empty.
         */
        $name = $this->currentTranslations[MY_Controller::getCurrentLocale()]->name;
        if ($this->getUrl() == '') {
            $ci = & get_instance();
            $ci->load->helper('translit');
            $this->setUrl(translit_url($name));
        }

        return true;
    }

    public function preInsert() {
        // Select max position
        $maxPositionCategory = SCategoryQuery::create()
                ->orderByPosition('desc')
                ->findOne();

        /**
         *  Set max position to all new categories
         */
        if ($maxPositionCategory)
            $this->setPosition($maxPositionCategory->getPosition() + 1);
        else
            $this->setPosition(1);

        return true;
    }

//   /**
//    * Delete subcategories and related products.
//    *
//    * @access public
//    * @return boll
//    */
//   public function preDelete()
//   {
//        return true;
//   }
//    public function postDelete()
//    {
//        // Remove orphans.
//		// ShopCore::app()->SCategoryTree->removeOrphans();
//        return true;
//    }
//    public function postSave()
//    {
//        return true;
//    }

    public function hasSubCats() {
        $sub_cats_arr = array();
        $sub_cats_arr[] = $this->getId();

        $sub_cats = SCategoryQuery::create()
                ->filterByParentId($this->getId())
                ->count();

        if ($sub_cats > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getChildsByParentId($id) {
        return SCategoryQuery::create()->findByParentId($id);
    }

    public function getChildsByParentIdI18n($id) {
        return SCategoryQuery::create()
                        ->filterByActive(1)
                        ->joinWithI18n(MY_Controller::getCurrentLocale())
                        ->orderByPosition()
                        ->findByParentId($id);
    }

    public function buildCategoryPath($criteria = Criteria::ASC, $locale = FALSE) {
        $ids = array();
        $result = array();
        $pathArray = unserialize($this->getFullPathIds());

        // Push self id
        array_push($pathArray, $this->getId());

        if (sizeof($pathArray) >= 1) {
            foreach ((array) $pathArray as $key => $val) {
                array_push($ids, $val);
            }

            $result = SCategoryQuery::create()
                    ->orderByParentId($criteria)
                    ->_if($locale)
                    ->joinWithI18n(\MY_Controller::getCurrentLocale())
                    ->_endif()
                    ->findPKs($ids);
        }
        return $result;
    }

    public function countProperties() {
        $cr = SPropertiesQuery::create()
                ->joinWithI18n(MY_Controller::getCurrentLocale())
                ->filterByActive(TRUE)
                ->filterByShowOnSite(TRUE);
        return $this->getProperties($cr)->count();
    }

    public function getProperties($showOnSite = true) {
        
        $cr = SPropertiesQuery::create()
                ->orderByPosition(Criteria::ASC)
                ->joinWithI18n(MY_Controller::getCurrentLocale())
                ->filterByActive(TRUE);
        
        if ($showOnSite) {
            $cr->filterByShowOnSite(TRUE);
        }
        
        return $cr->find();
    }

    /**
     * Get sample hits list from the same category as current product.
     *
     * @param int $limit
     * @return array|bool|mixed|PropelObjectCollection
     */
    public function getSampleHitsModels($limit = 5) {
        $models = SProductsQuery::create()
                ->joinWithI18n(MY_Controller::getCurrentLocale())
                ->orderByCreated(Criteria::DESC)
                ->filterByHit(1)
                ->filterByCategoryId($this->getId())
                ->limit($limit)
                ->find();

        if (sizeof($models) > 0) {
            return $models;
        }

        return false;
    }

    /**
     * Get sample popular list from the same category as current product.
     *
     * @param int $limit
     * @return array|bool|mixed|PropelObjectCollection
     */
    public function getSamplePopularModels($limit = 5) {
        $models = SProductsQuery::create()
                ->joinWithI18n(MY_Controller::getCurrentLocale())
                ->orderByViews(Criteria::DESC)
                ->where('SProducts.Views > ?', 1)
                ->filterByCategoryId($this->getId())
                ->limit($limit)
                ->find();

        if (sizeof($models) > 0) {
            return $models;
        }

        return false;
    }

    /**
     * Get sample new products list from the same category as current product.
     *
     * @param int $limit
     * @return array|bool|mixed|PropelObjectCollection
     */
    public function getSampleNewestModels($limit = 6) {
        $models = SProductsQuery::create()
                ->joinWithI18n(MY_Controller::getCurrentLocale())
                ->orderByCreated(Criteria::DESC)
                ->filterByCategoryId($this->getId())
                ->filterByHot(1)
                ->limit($limit)
                ->find();

        if (sizeof($models) > 0) {
            return $models;
        }

        return false;
    }

    /**
     * Populates the translatable object using an array.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return     void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME) {
        $peerName = get_class($this) . I18nPeer;
        $keys = $peerName::getFieldNames($keyType);

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

    public function getTranslatableFieldNames($keyType = SCategoryTableMap::TYPE_PHPNAME) {
        $keys = SCategoryI18nTableMap::getFieldnames($keyType);
        $keys = array_flip($keys);

        if (array_key_exists('Locale', $keys)) {
            unset($keys['Locale']);
        }

        if (array_key_exists('Id', $keys)) {
            unset($keys['Id']);
        }

        return array_flip($keys);
    }

    public function toArray($keyType = SCategoryTableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false) {
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

    public function makePageKeywords() {
        if ($this->getMetaKeywords() != "")
            return $this->getMetaKeywords();
        else {
            return $this->virtualColumns['title'];
        }
    }

    public function makePageTitle() {
        if ($this->getMetaTitle() != "")
            return $this->getMetaTitle();
        else {
            $fortitle = $this->buildCategoryPath(Criteria::DESC);
            foreach ($fortitle as $item)
                $title .= $item->getName() . ' - ';
            $title = rtrim($title, ' - ');

            return $title;
        }
    }

    public function makePageDesc() {
        $ci = & get_instance();
        $desc = $this->getMetaDesc();
        if ($desc)
            return $desc;
        else {
//            $ci->db->cache_on();
//            $ids = $ci->db
//                            ->where('id', $this->getId())
//                            ->get('shop_category')
//                            ->row()->full_path_ids;
//            $ids = unserialize($ids);
//            array_push($ids, $this->getId());
//            $ids = implode(',', $ids);
//
//            $ci->db->query("CREATE TEMPORARY TABLE brand_count AS (
//                                select distinct shop_brands_i18n.name,shop_brands.url,shop_products.id
//                                                from shop_brands
//                                                join shop_products on shop_products.brand_id = shop_brands.id
//                                                join shop_brands_i18n on shop_brands_i18n.id = shop_brands.id
//                                                join shop_product_categories on shop_product_categories.product_id = shop_products.id
//                                                where shop_brands_i18n.locale = '" . MY_Controller::getCurrentLocale() . "' and (shop_products.category_id in ($ids) or shop_product_categories.category_id in ($ids))
//                            )");
//            $brands = $ci->db->query("
//                select count(url) as count_b, name from  brand_count group by url order by count_b desc limit 5")->result();
//
//            $ci->db->cache_off();
//
//            foreach ($brands as $brand)
//                $str.= $brand->name . ' - ';

            return $this->getName() . ' ' . rtrim($str, ' - ');
        }
    }

}

// SCategory
