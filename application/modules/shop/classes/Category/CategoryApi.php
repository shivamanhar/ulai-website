<?php

namespace Category;

(defined("BASEPATH")) OR exit("No direct script access allowed");

/**
 * Category Api
 *
 * @uses \ShopController
 * @package Shop
 * @copyright 2014 ImageCMS
 * @author Dev ImageCMS <dev
 * @access public
 * @link URL 
 * @version 1.0
 */
class CategoryApi extends \ShopController {

    /** CategoryApi instance */
    protected static $_instance;

    /**
     * Error message.
     * @var string 
     */
    protected $error = '';

    /**
     * Categories array
     * @var array 
     */
    private $categories = array();

    /**
     * Categories Urls array
     * @var array 
     */
    private $categoriesUrlsData = array();

    public function __construct() {
        parent::__construct();
    }

    private function __clone() {
        
    }

    /**
     * Get CategoryApi instance
     * 
     * @return CategoryApi
     */
    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Set error message.
     * 
     * @param string $msg
     */
    private function setError($msg) {
        $this->error = $msg;
    }

    /**
     * Return error message.
     * 
     * @return string
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Add category
     * 
     * @param array $data data category array 
     *  <br>string $data['url'] category url 
     *  <br>int $data['parent_id'] category parent id, 0 if main category 
     *  <br>int $data['active'] is category active, can bo '1' or '0' 
     *  <br>string $data['external_id'] 1C indentificator of category 
     *  <br>string $data['image'] category image
     *  <br>string $data['tpl'] category template, if empty set default template
     *  <br>int $data['order_method'] category order method
     *  <br>int $data['showsitetitle'] if '1' will show site title on category
     *  <br>string $data['name'] category name
     *  <br>string $data['h1'] category h1
     *  <br>string $data['description'] category description
     *  <br>string $data['meta_desc'] category meta description
     *  <br>string $data['meta_title'] category meta title
     *  <br>string $data['meta_keywords'] category meta keywords
     * @param string $locale category translation locale
     * @return boolean|\SCategory
     * @throws \Exception
     */
    public function addCategory(array $data, $locale = 'ru') {
        try {

            if ($data === NULL) {
                throw new \Exception(lang('You did not specified data array'));
            }

            if (!is_array($data)) {
                throw new \Exception(lang('Second parameter $data must be array'));
            }

            $data = $this->_validateCategoryData($data);

            $model = new \SCategory();
            $model->setUrl($data['url']);
            $model->setParentId($data['parent_id']);
            $model->setActive($data['active']);
            $model->setExternalId($data['external_id']);
            $model->setImage($data['image']);
            $model->setTpl($data['tpl']);
            $model->setOrderMethod($data['order_method']);
            $model->setShowsitetitle($data['showsitetitle']);
            $model->setCreated($data['created']);
            $model->setUpdated($data['updated']);
            $model->save();

            $model->setFullPathIds($this->_makeFullPathIds($model->getId(), $data));
            $model->setFullPath($this->_makeFullPath($data));
            $model->save();

            $this->addCategoryI18N($model->getId(), $data, $locale);
            return $model;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    public function findOneCategoryByFullPath($categoryFullPath, $locale = 'ru', $active = TRUE) {
        try {
            $cat = \SCategoryQuery::create()
                    ->joinWithI18n($locale)
                    ->withColumn('IF(H1 IS NOT NULL AND H1 NOT LIKE "", H1, Name)', 'title')
                    ->filterByFullPath($categoryFullPath)
                    ->filterByActive($active)
                    ->findOne();
        } catch (\PropelException $exc) {
            $this->setError($exc->getMessage());
        }

        return $cat;
    }

    /**
     * Add category translation by ID and locale
     * 
     * @param int $categoryId -category ID
     * @param array $data - data category array 
     * @param string $locale - category translation locale
     * @return boolean|\SCategoryI18n
     * @throws \Exception
     */
    public function addCategoryI18N($categoryId, array $data, $locale = 'ru') {
        try {
            if (!$categoryId) {
                throw new \Exception(lang('Category(ies) id(s) not specified'));
            }

            if ($data === NULL) {
                throw new \Exception(lang('You did not specified data array'));
            }

            if (!is_array($data)) {
                throw new \Exception(lang('Second parameter $data must be array'));
            }

            $model = new \SCategoryI18n();
            $model->setId($categoryId);
            $model->setLocale($locale);
            $model->setName($data['name']);
            $model->setH1($data['h1']);
            $model->setDescription($data['description']);
            $model->setMetaDesc($data['meta_desc']);
            $model->setMetaTitle($data['meta_title']);
            $model->setMetaKeywords($data['meta_keywords']);
            $model->save();
            return $model;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Update category by ID
     * 
     * @param int $categoryId - category ID
     * @param array $data - data to update
     * @param string $locale - category translation locale
     * @return boolean
     * @throws \Exception
     */
    public function updateCategory($categoryId, $data = array(), $locale = 'ru') {
        try {
            if (!$categoryId) {
                throw new \Exception(lang('Category(ies) id(s) not specified'));
            }

            if ($data === NULL) {
                throw new \Exception(lang('You did not specified data array'));
            }

            if (!is_array($data)) {
                throw new \Exception(lang('Second parameter $data must be array'));
            }

            $data['category_id'] = $categoryId;
            $data = $this->_validateCategoryData($data, 'update');

            /** Get category model */
            $model = \SCategoryQuery::create()->findOneById($categoryId);

            if (count($model) > 0) {
                /** Update category model */
                $model->setUrl($data['url']);
                $model->setParentId($data['parent_id']);
                $model->setFullPathIds($this->_makeFullPathIds($categoryId, $data));
                $model->setFullPath($this->_makeFullPath($data));
                $model->setActive($data['active']);
                $model->setExternalId($data['external_id'] ? $data['external_id'] : $model->getExternalId());
                $model->setImage($data['image']);
                $model->setTpl($data['tpl']);
                $model->setOrderMethod($data['order_method']);
                $model->setShowsitetitle($data['showsitetitle']);
                $model->setUpdated($data['updated']);
                $model->save();

                /** Update category i18n */
                if (!$this->updateCategoryI18N($categoryId, $data, $locale)) {
                    $this->addCategoryI18N($categoryId, $data, $locale);
                }

                /** Update categories full path */
                $this->updateFullPaths($categoryId);
                return $model;
            } else {
                throw new \Exception(lang('Category with such ID not exist'));
            }
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Update category translation by ID and locale
     * 
     * @param int $categoryId - category ID
     * @param array $data - data array to update
     * @param string $locale - translation locale
     * @return boolean
     * @throws \Exception
     */
    public function updateCategoryI18N($categoryId, $data = array(), $locale = 'ru') {
        try {
            if (!$categoryId) {
                throw new \Exception(lang('Category(ies) id(s) not specified'));
            }

            if ($data === NULL) {
                throw new \Exception(lang('You did not specified data array'));
            }

            if (!is_array($data)) {
                throw new \Exception(lang('Second parameter $data must be array'));
            }

            /** Get category translation model */
            $model = \SCategoryI18nQuery::create()->filterByLocale($locale)->findOneById($categoryId);

            if (count($model) > 0) {
                /** Update category translation model */
                $model->setName($data['name']);
                $model->setH1($data['h1']);
                $model->setDescription($data['description']);
                $model->setMetaDesc($data['meta_desc']);
                $model->setMetaTitle($data['meta_title']);
                $model->setMetaKeywords($data['meta_keywords']);
                $model->save();
                return $model;
            } else {
                return FALSE;
            }
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Get category(ies) by ID(s)
     * 
     * @param type $categoryId - category id or array of categories ids
     * @param array $where - where query condition (example: array('SCategory.Url = ?' => 'category_url'))
     * @param array $orderBy - order query condition (example: array('SCategory.Id' => 'asc'))
     * @param string $locale - locale to join with i18n category
     * @return boolean
     */
    public function getCategory($categoryId, $where = array(), $orderBy = array(), $locale = 'ru') {
        /** Start get category */
        $category = \SCategoryQuery::create()->joinWithI18n($locale);

        if ($categoryId) {
            $category->filterById($categoryId);
        }

        /** Where condition to filter query */
        if ($where) {
            foreach ($where as $condition => $value) {
                $category->where($condition, $value);
            }
        }

        /** Order condition to order result */
        if ($orderBy) {
            foreach ($orderBy as $condition => $value) {
                $category->orderBy($condition, $value);
            }
        }

        $result = $category->find();
        /** End get category */
        if (count($result) > 0) {
            return $result;
        } else {
            $this->setError(lang('Category(ies) was not found'));
            return FALSE;
        }
    }

    /**
     * Delete category(ies) by ID(s)
     * 
     * @param type $categoryId - category id or array of categories ids
     * @return boolean
     */
    public function deleteCategory($categoryId) {
        if (!$categoryId) {
            $this->setError(lang('Category(ies) id(s) not specified'));
            return FALSE;
        }

        $model = \SCategoryQuery::create()->findById($categoryId);
        if ($model) {
            /** Delete category products images */
            $categories_ids = is_array($categoryId) ? $categoryId : array($categoryId);
            \MediaManager\Image::create()->deleteImagebyCategoryId($categories_ids);

            /* Getting all childs of specified categories (if any) */
            $allCategoriesIds = array();
            foreach ($categories_ids as $categoryId) {
                $allCategoriesIds[] = $categoryId;
                $childs = $this->getChildsRecursive($categoryId);
                foreach ($childs as $cId) {
                    $allCategoriesIds[] = $cId;
                }
            }
            $allCategoriesIds = array_unique($allCategoriesIds);

            /* Getting all products of specifies categories */
            $productsIds = $this->db->select(array('id'))
                            ->where_in('category_id', $allCategoriesIds)
                            ->get('shop_products')->result_array();

            array_walk($productsIds, function(&$item, $key) {
                $item = $item['id'];
            });

            /** Delete products comments */
            if (count($productsIds)) {
                if (count($products_ids) > 0) {
                    $this->db->where_in('item_id', $productsIds)->where('module', 'shop')->delete('comments');
                }
            }

            /* Deleting data from cart (if product is in cart) */
            $result = $this->db
                    ->select(array('id', 'cart_data'))
                    ->get('users')
                    ->result_array();

            $cartData = \SplFixedArray::fromArray($result);

            $cartDataForUpdate = array();
            for ($i = 0; $i < count($cartData); $i++) {
                if (empty($cartData[$i]['cart_data'])) {
                    continue;
                }

                $userCartData = unserialize($cartData[$i]['cart_data']);
                if (!is_array($userCartData)) {
                    continue;
                }

                foreach ($userCartData as $key => $cartItemData) {
                    if ($cartItemData['instance'] == 'SProducts' && in_array($cartItemData['productId'], $productsIds)) {
                        unset($userCartData[$key]);
                        // it can be only one unique product item in cart
                        $cartDataForUpdate[] = array(
                            'id' => $cartData[$i]['id'],
                            'cart_data' => count($userCartData) > 0 ? serialize($userCartData) : ''
                        );
                        break;
                    }
                }
            }

            /** Update users cart data  */
            if (count($cartDataForUpdate) > 0) {
                $this->db->update_batch('users', $cartDataForUpdate, 'id');
            }

            /** Delete category */
            $model->delete();
        } else {
            $this->setError(lang('Category(ies) not exists'));
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Returns all childs of category (from all sub-levels)
     * @param int $categoryId
     * @return array
     */
    private function getChildsRecursive($categoryId) {
        $this->getCategoriesFromDB();
        $childsIds = array();
        foreach ($this->categories as $categoryData) {
            if ($categoryId == $categoryData['parent_id']) {
                $childsIds[] = $categoryData['id'];
                $subChilds = $this->getChildsRecursive($categoryData['id']);
                if (count($subChilds) > 0) {
                    foreach ($subChilds as $categoryId_) {
                        $childsIds[] = $categoryId_;
                    }
                }
            }
        }
        return $childsIds;
    }

    /**
     * Getting categories from db into $this->categories var 
     * (only if were not selected already)
     * @param boolean $force (optional, default false) if true and categories 
     * was already selected then they will be overriden (useful on after changing)
     */
    private function getCategoriesFromDB($force = FALSE) {
        if (!$this->categories || $force !== FALSE) {
            $categories = $this->db->get('shop_category');
            $categories = $categories ? $categories->result_array() : array();

            foreach ($categories as $row) {
                $this->categories[$row['id']] = $row;
            }
        }
    }

    /**
     * Make category full path url
     * 
     * @param array $data - data array
     * @return type
     * @throws \Exception
     */
    private function _makeFullPath($data) {
        if ($data === NULL || !is_array($data)) {
            return $data['url'];
        }

        $data['parent_id'] = (int) $data['parent_id'] ? (int) $data['parent_id'] : 0;

        if ($data['parent_id']) {
            /** Get parent category */
            $parentCategory = \SCategoryQuery::create()->findOneById($data['parent_id']);

            /** Set full path */
            if (count($parentCategory) > 0) {
                $data['full_path'] = $parentCategory->getFullPath() . '/' . $data['url'];
            } else {
                $data['full_path'] = $data['url'];
            }
            return $data['full_path'];
        } else {
            $data['full_path'] = $data['url'];
            return $data['full_path'];
        }
    }

    /**
     * Make category full path ids
     * 
     * @param array $data - data array
     * @return type
     * @throws \Exception
     */
    private function _makeFullPathIds($category_id, $data) {
        if (($data === NULL || !is_array($data)) || !$category_id) {
            return serialize(array());
        }

        $data['parent_id'] = (int) $data['parent_id'] ? (int) $data['parent_id'] : 0;

        if ($data['parent_id']) {
            /** Get parent category */
            $parentCategory = \SCategoryQuery::create()->findOneById($data['parent_id']);

            /** Set full path ids */
            if (count($parentCategory) > 0) {
                $parentCategoryFullPathIds = unserialize($parentCategory->getFullPathIds());
                array_push($parentCategoryFullPathIds, $data['parent_id']);
                $data['full_path_ids'] = serialize($parentCategoryFullPathIds);
            } else {
                $data['full_path_ids'] = serialize(array());
            }
            return $data['full_path_ids'];
        } else {
            $data['full_path_ids'] = serialize(array());
            return $data['full_path_ids'];
        }
    }

    private function _validateCategoryData(array $data, $type = 'create') {
        if ($data['url']) {
            if (!preg_match("/\b[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $data['url'])) {
                throw new \Exception(lang('Invalid url'));
            }

            // Check if Url is aviable.
            $this->db->where('url', $data['url']);

            if ($type == 'update') {
                $this->db->where('id !=', $data['category_id']);
            }

            $urlCheck = $this->db->get('shop_category');

            if ($urlCheck->num_rows() > 0) {
                throw new \Exception(lang('This URL is already in use!'));
            }
        } else {
            $this->load->helper('translit');

            $this->db->where('url', translit_url($data['name']));

            if ($type == 'update') {
                $this->db->where('id !=', $data['category_id']);
            }

            $urlCheck = $this->db->get('shop_category');

            if ($urlCheck->num_rows() > 0) {
                throw new \Exception(lang('This URL is already in use!'));
            }

            $data['url'] = translit_url($data['name']);
        }

        if ($data['active']) {
            if (!in_array($data['active'], array(1, 0))) {
                throw new \Exception(lang("active not 1 or 0"));
            }
        } else {
            $data['active'] = 0;
        }

        if ($data['showsitetitle']) {
            if (!in_array($data['showsitetitle'], array(1, 0))) {
                throw new \Exception(lang("showsitetitle not 1 or 0"));
            }
        } else {
            $data['showsitetitle'] = 0;
        }

        if ($data['order_method']) {
            if (!filter_var($data['order_method'], FILTER_VALIDATE_INT)) {
                throw new \Exception(lang("Invalid order method"));
            }
        } else {
            $data['order_method'] = 0;
        }

        if ($data['parent_id']) {
            if (!filter_var($data['parent_id'], FILTER_VALIDATE_INT)) {
                throw new \Exception(lang("Invalid parent_id"));
            }
        } else {
            $data['parent_id'] = 0;
        }

        if ($data['tpl']) {
            if (mb_strlen($data['tpl']) > 250) {
                throw new \Exception(lang("The tpl field legth must be smaler than 250 symbols."));
            }

            if (preg_match('/^[A-Za-z\_\.\d]{0,250}$/', $data['tpl']) !== 1) {
                throw new \Exception(lang("The tpl field can only contain Latin alpha-numeric characters"));
            }
        }

        if ($data['image']) {
            if (preg_match('/\.jpg|\.png|\.gif|\.jpeg/i', $data['image']) !== 1) {
                throw new \Exception(lang("Invalid file type."));
            }
        }

        return $data;
    }

    /**
     * Get category tree
     * 
     * @param boolean $loadUnactive - TRUE to load unactive categories, FALSE - not load
     * @return array|boolean
     */
    public function getTree($loadUnactive = TRUE) {
        /** Check to load unactive categories */
        \ShopCore::app()->SCategoryTree->setLoadUnactive($loadUnactive);

        /** Get category tree */
//        $tree = \ShopCore::app()->SCategoryTree->getTree();
        $tree = \ShopCore::app()->SCategoryTree->getTree();

        /** Return tree */
        if (count($tree) > 0) {
            return $tree;
        } else {
            $this->setError(lang('Can not buid category tree'));
            return FALSE;
        }
    }

    /**
     * Update children categories full path
     * 
     * @param int $categoryId - category id, which url is changed
     * @return boolean
     */
    private function updateFullPaths($categoryId) {
        if (!$categoryId) {
            return FALSE;
        }

        // Get all children
        $children = $this->getChildren($categoryId);
        if (count($children) > 0) {
            $this->updateChildrenUrls($children);

            /** Update categories urls */
            if ($this->categoriesUrlsData) {
                $this->db->update_batch('shop_category', $this->categoriesUrlsData, 'id');
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Get category children ids
     * 
     * @param int $categoryId - category id, which url is changed
     * @return array
     */
    public function getChildren($categoryId) {
        $childs = array();
        /** Get all categories */
        $this->getCategoriesFromDB();

        /** Prepare array with children ids */
        foreach ($this->categories as $categoryData) {
            if ($categoryId == $categoryData['parent_id']) {
                $childs[] = $categoryData['id'];
            }
        }

        return $childs;
    }

    /**
     * Update children urls
     * 
     * @param array $childrenIds - children ids
     */
    private function updateChildrenUrls($childrenIds) {
        /** Get children by ids  */
        $result = $this->db
                ->select(array('id', 'parent_id', 'url'))
                ->where_in('id', $childrenIds)
                ->get('shop_category')
                ->result_array();

        $categories = array();
        foreach ($result as $row) {
            $categories[$row['id']] = $row;
        }
        unset($result);

        $paths = array();
        foreach ($categories as $categoryId => $categoryData) {
            // building path 
            $neededCid = $categoryId;
            $path = array();

            while ($neededCid != 0) {
                $path[] = $this->categories[$neededCid]['url'];
                $neededCid = $this->categories[$neededCid]['parent_id'];
            }

            $path = array_reverse($path);

            $paths[$categoryId] = $path;

            $childrenIds_ = $this->getChildren($categoryId);

            $this->categoriesUrlsData[] = array('id' => $categoryId, 'full_path' => implode('/', $path));

            if (count($childrenIds_) > 0) {
                $this->updateChildrenUrls($childrenIds_);
            }
        }
    }

}

/* End of file CategoryApi.php _Admin_ ImageCms */