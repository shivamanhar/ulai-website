<?php

namespace Products;

use Propel\Runtime\ActiveQuery\Criteria;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Shop Controller
 *
 * @uses \ShopController
 * @package Shop
 * @copyright 2014 ImageCMS
 * @author Dev ImageCMS <dev
 * @access public
 * @link URL 
 * @version 1.0
 */
class ProductApi extends \ShopController {

    protected static $_instance;

    /**
     * Error message.
     * @var string 
     */
    protected $error = '';

    public function __construct() {
        parent::__construct();
    }

    private function __clone() {
        
    }

    /**
     *
     * @return ProductApi
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
     * Create product and variant.
     * 
     * @param array $data array of product data for insert
     * <br> string $data['url'] (optional) product url
     * <br> int $data['active'] (optional) is product will be show in store - 1 or 0
     * <br> int $data['brand_id'] (optional) brand id
     * <br> int $data['category_id'] (required) category id
     * <br> array $data['additional_categories_ids'] (optional) product additional categories
     * <br> string $data['related_products'] (optional) related products for current product
     * <br> int $data['created'] (optional) unix timestamp 
     * <br> int $data['updated'] (optional) unix timestamp   
     * <br> float $data['old_price'] (optional) old price of product   
     * <br> int $data['views'] (optional) count of views  
     * <br> int $data['hot'] (optional) is product type is "hot" - 1 or 0
     * <br> int $data['action'] (optional) is product type is "action" - 1 or 0
     * <br> int $data['added_to_cart_count'] (optional) count of adding to cart  
     * <br> int $data['enable_comments'] (optional) allow leave comments for product - 1 or 0
     * <br> string $data['external_id'] (optional) product external id
     * <br> string $data['tpl'] (optional) set non-standard template file for product
     * <br> int $data['user_id'] (optional) user id who create product
     * <br> string $data['product_name'] (required) product name
     * <br> string $data['short_description'] (optional) short description
     * <br> string $data['full_description'] (optional) full description
     * <br> string $data['meta_title'] (optional) meta title
     * <br> string $data['meta_description'] (optional) meta description
     * <br> string $data['meta_keywords'] (optional) meta keywords
     * <br> string $data['number'] (optional) product SKU
     * <br> int $data['stock'] (optional) count of products in warehouse
     * <br> int $data['position'] (optional) variant position
     * <br> string $data['mainImage'] (optional) product image
     * <br> string $data['var_external_id'] (optional) variant external id
     * <br> int $data['currency'] (required) currency id
     * <br> float $data['price_in_main'] (required) price in main currency
     * <br> string $data['variant_name'] (optional) product variant name
     * <br> string $data['enable_comments'] (optional) enable comments
     * @param string $locale locale
     * @return mixed
     */
    public function addProduct($data = array(), $locale = 'ru') {
        try {
            $this->error = '';

            if ($data === NULL) {
                throw new \Exception(lang('You did not specified data array'));
            }

            if (!is_array($data)) {
                throw new \Exception(lang('Second parameter $data must be array'));
            }

            $data = $this->_validateProductData($data);

            $model = new \SProducts;
            $model = $this->_setProductData($model, $data, 'create');

            $this->addProductI18N($model->getId(), $data, $locale);

            $this->addVariant($model->getId(), $data, $locale);

            $this->setProductAdditionalCategories($model, $data);

            \Currency\Currency::create()->checkPrices();

            return $model;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Create translation for existing product.
     * 
     * @param int $productId
     * @param array $data
     * <br> string $data['product_name'] (required) product name
     * <br> string $data['short_description'] (optional) short description
     * <br> string $data['full_description'] (optional) full description
     * <br> string $data['meta_title'] (optional) meta title
     * <br> string $data['meta_description'] (optional) meta description
     * <br> string $data['meta_keywords'] (optional) meta keywords
     * @param string $locale 
     */
    public function addProductI18N($productId, $data = array(), $locale = 'ru') {
        try {
            $model = new \SProductsI18n();
            $this->_setProductI18NData($productId, $model, $data, $locale);
            return $model;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Create variant for product.
     * 
     * @param int $productId
     * @param array $data
     * <br> string $data['number'] (optional) product SKU
     * <br> int $data['stock'] (optional) count of products in warehouse
     * <br> int $data['position'] (optional) variant position
     * <br> string $data['mainImage'] (optional) product image
     * <br> string $data['var_external_id'] (optional) variant external id
     * <br> int $data['currency'] (required) currency id
     * <br> float $data['price_in_main'] (optional) price in main currency
     * <br> string $data['variant_name'] (optional) product variant name
     */
    public function addVariant($productId, $data = array(), $locale = 'ru') {
        try {
            $model = new \SProductVariants;
            $model = $this->_setVariantData($productId, $model, $data, $locale);

            $this->addVariantI18N($model->getId(), $data, $locale);

            \Currency\Currency::create()->checkPrices();
            return $model;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Add product variant translation by variant ID
     * @param int $variantId
     * @param array $data
     * <br> string $data['variant_name'] (optional) product variant name
     * @param string $locale 
     */
    public function addVariantI18N($variantId, $data = array(), $locale = 'ru') {
        try {
            $model = new \SProductVariantsI18n();
            $model->setId($variantId);
            $model->setLocale($locale);
            $model->setName($data['variant_name']);
            $model->save();
            return $model;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Update product by ID
     * @param type $productId - product id
     * @param array $data array of product data for update
     * <br> string $data['url'] (optional) product url
     * <br> int $data['active'] (optional) is product will be show in store - 1 or 0
     * <br> int $data['brand_id'] (optional) brand id
     * <br> int $data['category_id'] (required) category id
     * <br> array $data['additional_categories_ids'] (optional) product additional categories
     * <br> string $data['related_products'] (optional) related products for current product
     * <br> int $data['updated'] (optional) unix timestamp   
     * <br> float $data['old_price'] (optional) old price of product   
     * <br> int $data['views'] (optional) count of views  
     * <br> int $data['hot'] (optional) is product type is "hot" - 1 or 0
     * <br> int $data['action'] (optional) is product type is "action" - 1 or 0
     * <br> int $data['added_to_cart_count'] (optional) count of adding to cart  
     * <br> int $data['enable_comments'] (optional) allow leave comments for product - 1 or 0
     * <br> string $data['external_id'] (optional) product external id
     * <br> string $data['tpl'] (optional) set non-standard template file for product
     * <br> int $data['user_id'] (optional) user id who create product
     * <br> string $data['product_name'] (required) product name
     * <br> string $data['short_description'] (optional) short description
     * <br> string $data['full_description'] (optional) full description
     * <br> string $data['meta_title'] (optional) meta title
     * <br> string $data['meta_description'] (optional) meta description
     * <br> string $data['meta_keywords'] (optional) meta keywords
     * <br> float $data['price'] (required) product price
     * <br> string $data['number'] (optional) product SKU
     * <br> int $data['stock'] (optional) count of products in warehouse
     * <br> int $data['position'] (optional) variant position
     * <br> string $data['mainImage'] (optional) product image
     * <br> string $data['var_external_id'] (optional) variant external id
     * <br> int $data['currency'] (required) currency id
     * <br> float $data['price_in_main'] (optional) price in main currency
     * <br> string $data['variant_name'] (optional) product variant name
     * <br> string $data['enable_comments'] (optional) enable comments
     * @param string $locale 
     * @return type
     */
    public function updateProduct($productId, $data = array(), $locale = 'ru', $variant_id = NULL) {
        try {
            if (!$productId) {
                throw new \Exception(lang('You did not specified product id'));
            }

            if ($data === NULL) {
                throw new \Exception(lang('You did not specified data array'));
            }

            if (!is_array($data)) {
                throw new \Exception(lang('Second parameter $data must be array'));
            }

            $data['product_id'] = $productId;
            $data = $this->_validateProductData($data, 'update');
            $model = \SProductsQuery::create()->findPk($productId);

            if ($model) {
                $model = $this->_setProductData($model, $data);

                $this->updateProductI18N($model->getId(), $data, $locale);

                $this->updateVariant($productId, $data, $locale, $variant_id);

                $this->setProductAdditionalCategories($model, $data);
            } else {
                throw new \Exception(lang('Product with such ID not exist'));
            }
            return $model;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Update transaltion for product 
     * 
     * @param int $productId
     * @param array $data
     * <br> string $data['product_name'] (required) product name
     * <br> string $data['short_description'] (optional) short description
     * <br> string $data['full_description'] (optional) full description
     * <br> string $data['meta_title'] (optional) meta title
     * <br> string $data['meta_description'] (optional) meta description
     * <br> string $data['meta_keywords'] (optional) meta keywords
     * @param string $locale
     * @return boolean
     * @throws \Exception
     */
    public function updateProductI18N($productId, array $data, $locale = 'ru') {
        try {

            if (!$productId) {
                throw new \Exception(lang('You did not specified product id'));
            }

            if ($data === NULL) {
                throw new \Exception(lang('You did not specified data array'));
            }

            if (!is_array($data)) {
                throw new \Exception(lang('Second parameter $data must be array'));
            }

            $model = \SProductsI18nQuery::create()->filterByLocale($locale)->findOneById($productId);
            if (!$model) {
                $model = $this->addProductI18N($productId, $data, $locale);
            }
            $this->_setProductI18NData($productId, $model, $data, $locale);
            return $model;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Update variant by product ID
     * 
     * @param int $productId product ID
     * @param array $data data array to update
     * <br> float $data['price'] (required) product price
     * <br> string $data['number'] (optional) product SKU
     * <br> int $data['stock'] (optional) count of products in warehouse
     * <br> int $data['position'] (optional) variant position
     * <br> string $data['mainImage'] (optional) product image
     * <br> string $data['var_external_id'] (optional) variant external id
     * <br> int $data['currency'] (required) currency id
     * <br> float $data['price_in_main'] (optional) price in main currency
     * <br> string $data['variant_name'] (optional) product variant name
     * @param string $locale product variant locale
     * @param int $variantId variant id
     */
    public function updateVariant($productId, array $data, $locale = 'ru', $variantId = NULL) {
        try {

            if (!$productId) {
                throw new \Exception(lang('You did not specified product id'));
            }

            if ($data === NULL) {
                throw new \Exception(lang('You did not specified data array'));
            }

            if (!is_array($data)) {
                throw new \Exception(lang('Second parameter $data must be array'));
            }

            if ($variantId) {
                $model = \SProductVariantsQuery::create()->filterById($variantId)->findOne();
            } else {
                $model = \SProductVariantsQuery::create()->findOneByProductId($productId);
            }

            if (!$model) {
                throw new \Exception(lang('Product variant not found'));
            }
            $model = $this->_setVariantData($productId, $model, $data);

            if (!$this->updateVariantI18N($model->getId(), $data, $locale)) {
                $this->addVariantI18N($model->getId(), $data, $locale);
            }

            return $model;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Update translation of product variant by variant ID
     * @param type $variantId product variant ID
     * @param array $data array to update
     * <br> string $data['variant_name'] (optional) product variant name
     * @param string $locale product variant locale
     * @param int $variantId
     * @return boolean
     * @throws \Exception
     */
    public function updateVariantI18N($variantId, array $data, $locale = 'ru') {
        try {

            if (!$variantId) {
                throw new \Exception(lang('You did not specified product variant id'));
            }

            if ($data === NULL) {
                throw new \Exception(lang('You did not specified data array'));
            }

            if (!is_array($data)) {
                throw new \Exception(lang('Second parameter $data must be array'));
            }

            $model = \SProductVariantsI18nQuery::create()->filterByLocale($locale)->findOneById($variantId);
            if (!$model) {
                return FALSE;
            }
            $model->setLocale($locale);
            $model->setName($data['variant_name']);
            $model->save();
            return $model;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Validations of product data for insert or update
     * 
     * @param array $data
     * @param type $type
     * @return boolean
     * @throws \Exception
     */
    private function _validateProductData(array $data, $type = 'create') {
        if ($data['url']) {
//            if (!preg_match("/\b[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $data['url'])) {
            if (!preg_match("/^[\w\d-._~:\[\]@!$&'()*+;=]*$/", $data['url'])) {
                throw new \Exception(lang('URL field can only contain alphanumeric characters and symbols: - , _'));
            }
            preg_match('/[а-яА-Я \/#?]/i', $data['url'], $url);
            if (!empty($url)) {
                throw new \Exception(lang('URL field can only contain alphanumeric characters and symbols: - , _'));
            }

            // Check if Url is aviable.
            $this->db->where('url', $data['url']);

            if ($type == 'update') {
                $this->db->where('id !=', $data['product_id']);
            }

            $urlCheck = $this->db->get('shop_products');

            if ($urlCheck->num_rows() > 0) {
                throw new \Exception(lang('This URL is already in use!'));
            }
        } else {
            $this->load->helper('translit');

            $this->db->where('url', translit_url($data['product_name']));

            if ($type == 'update') {
                $this->db->where('id !=', $data['product_name']);
            }

            $urlCheck = $this->db->get('shop_products');

            if ($urlCheck->num_rows() > 0) {
                throw new \Exception(lang('This URL is already in use!'));
            }

            $data['url'] = translit_url($data['product_name']);
        }

        if ($data['active']) {
            if (!in_array($data['active'], array(1, 0))) {
                throw new \Exception(lang("active not 1 or 0"));
            }
        } else {
            $data['active'] = 0;
        }

        if ((int) $data['enable_comments']) {
            if (!in_array((int) $data['enable_comments'], array(1, 0))) {
                throw new \Exception(lang("hit not 1 or 0"));
            }
        } else {
            $data['enable_comments'] = 0;
        }

        if ($data['stock']) {
            if (!is_int((int) $data['stock'])) {
                throw new \Exception(lang("Invalid stock"));
            }
        } else {
            $data['stock'] = 0;
        }

        if ($data['brand_id']) {
            if (!filter_var($data['brand_id'], FILTER_VALIDATE_INT)) {
                throw new \Exception(lang("Invalid brand_id"));
            }
        }
        if (!$data['product_name']) {
            throw new \Exception(lang("not specified product_name"));
        }

        if (!$data['currency']) {
            throw new \Exception(lang("currency not specified"));
        }

        if (count(\SCurrenciesQuery::create()->findById($data['currency'])) == 0) {
            throw new \Exception(lang("currency not exist"));
        }

        if (!isset($data['price_in_main'])) {
            throw new \Exception(lang("price_in_main not specified"));
        }

        if (!is_numeric(str_replace(',', '.', $data['price_in_main']))) {
            throw new \Exception(lang("price_in_main not float"));
        }

        if ($data['category_id']) {
            if (!filter_var($data['category_id'], FILTER_VALIDATE_INT)) {
                throw new \Exception(lang("Invalid category_id"));
            }
        } else {
            throw new \Exception(lang("category_id not specified"));
        }

        if ($data['additional_categories_ids']) {
            if (!is_array($data['additional_categories_ids'])) {
                $data['additional_categories_ids'] = array();
            }
        } else {
            $data['additional_categories_ids'] = array();
        }

//        if ($data['related_products']) {
//        if ($data['related_products']) {
//            throw new \Exception(lang("Invalid related_products"));
//        }}
        if ($data['created']) {
//                if (!$this->isValidTimeStamp($data['created'])) {
//                    throw new \Exception(lang("Invalid created"));
//                }
        } else {
            $data['created'] = time();
        }

        if ($data['updated']) {
//            if (!$this->isValidTimeStamp($data['updated'])) {
////                throw new \Exception(lang("Invalid updated"));
//            }
        } else {
            $data['updated'] = time();
        }
        if ((float) $data['old_price'] && is_numeric($data['old_price'])) {
            if (!filter_var($data['old_price'], FILTER_VALIDATE_FLOAT)) {
                throw new \Exception(lang("Invalid old_price"));
            }
        } else {
            $data['old_price'] = 0;
        }

        if ($data['views']) {
            if (!filter_var($data['views'], FILTER_VALIDATE_INT)) {
                throw new \Exception(lang("Invalid views"));
            }
        }

        if ($data['locale']) {
            
        }

        if ($data['added_to_cart_count']) {
            if (!filter_var($data['added_to_cart_count'], FILTER_VALIDATE_INT)) {
                throw new \Exception(lang("Invalid added_to_cart_count"));
            }
        } else {
            $data['added_to_cart_count'] = 0;
        }


        if ($data['external_id']) {
//            if (!in_array($data['external_id'], array(1, 0))) {
//                throw new \Exception(lang("Invalid external_id"));
//            }
        } else {
//            $data['external_id'] = 1;
        }

        if ($data['hot']) {
            if (!in_array($data['hot'], array(1, 0))) {
                throw new \Exception(lang("hot not 1 or 0"));
            }
        }

        if ($data['hit']) {
            if (!in_array($data['hit'], array(1, 0))) {
                throw new \Exception(lang("hit not 1 or 0"));
            }
        }

        if ($data['action']) {
            if (!in_array($data['action'], array(1, 0))) {
                throw new \Exception(lang("action not 1 or 0"));
            }
        }


        if ($data['tpl']) {
            if (preg_match('/^[A-Za-z\_\.\d]/', $data['tpl']) !== 1) {
                throw new \Exception(lang("The Main tpl field can only contain Latin alpha-numeric characters"));
            }
        }
        if ($data['tpl']) {
            if (preg_match('/^[A-Za-z\_\.\d]{0,250}$/', $data['tpl']) !== 1) {
                throw new \Exception(lang("The main template field can not contain more than 250 characters"));
            }
        }

        return $data;
    }

    /**
     * Check if $timestamp is in Unixtime
     * 
     * @param string $timestamp
     * @return bool
     */
    private function isValidTimeStamp($timestamp) {
        return ((string) (int) $timestamp === $timestamp) && ($timestamp <= PHP_INT_MAX) && ($timestamp >= ~PHP_INT_MAX);
    }

    /**
     * Set product data
     * @param \SProducts $model
     * @param array $data
     * <br> string $data['url'] (optional) product url
     * <br> int $data['active'] (optional) is product will be show in store - 1 or 0
     * <br> int $data['brand_id'] (optional) brand id
     * <br> int $data['category_id'] (required) category id
     * <br> string $data['related_products'] (optional) related products for current product
     * <br> int $data['created'] (optional) unix timestamp 
     * <br> int $data['updated'] (optional) unix timestamp  
     * <br> float $data['old_price'] (optional) old price of product   
     * <br> int $data['views'] (optional) count of views  
     * <br> int $data['hot'] (optional) is product type is "hot" - 1 or 0
     * <br> int $data['action'] (optional) is product type is "action" - 1 or 0
     * <br> int $data['added_to_cart_count'] (optional) count of adding to cart  
     * <br> int $data['enable_comments'] (optional) allow leave comments for product - 1 or 0
     * <br> string $data['external_id'] (optional) product external id
     * <br> string $data['tpl'] (optional) set non-standard template file for product
     * <br> int $data['user_id'] (optional) user id who create product 
     * @param string $type 'update' or 'create'
     * @return \SProductVariants
     */
    private function _setProductData($model, array $data, $type = 'update') {
        /* @var $model \SProducts */
        $model->setUrl($data['url']);
        $model->setActive($data['active']);
        $model->setBrandId($data['brand_id']);
        $model->setCategoryId($data['category_id']);
        $model->setRelatedProducts($data['related_products']);
        if ($type == 'create') {
            $model->setCreated($data['created'] ? $data['created'] : time());
        } else {
            $model->setCreated($data['created'] ? $data['created'] : $model->getCreated());
        }
        $model->setUpdated($data['updated'] ? $data['updated'] : time());
        $model->setOldPrice($data['old_price']);
        $model->setViews($data['views'] ? $data['views'] : $model->getViews());

        if ($data['hot'] !== NULL) {
            $model->setHot($data['hot']);
        }

        if ($data['action'] !== NULL) {
            $model->setAction($data['action']);
        }

        if ($data['hit'] !== NULL) {
            $model->setHit($data['hit']);
        }

        $model->setAddedToCartCount($data['added_to_cart_count']);
        $model->setEnableComments($data['enable_comments']);

        if ($data['external_id']) {
            $model->setExternalId($data['external_id']);
        }

        $model->setTpl($data['tpl']);
        $model->setUserId($data['user_id']);

        $model->save();

        return $model;
    }

    /**
     * Set productI18N data
     * @param type $productId
     * @param \SProductsI18n $model
     * @param array $data
     * <br> string $data['product_name'] (required) product name
     * <br> string $data['short_description'] (optional) short description
     * <br> string $data['full_description'] (optional) full description
     * <br> string $data['meta_title'] (optional) meta title
     * <br> string $data['meta_description'] (optional) meta description
     * <br> string $data['meta_keywords'] (optional) meta keywords
     * @param type $locale
     * @return \SProductsI18n
     */
    private function _setProductI18NData($productId, $model, array $data, $locale = 'ru') {
        $model->setId($productId);
        $model->setMetaKeywords($data['meta_keywords']);
        $model->setMetaDescription($data['meta_description']);
        $model->setMetaTitle($data['meta_title']);
        $model->setFullDescription($data['full_description']);
        $model->setShortDescription($data['short_description']);
        $model->setName($data['product_name']);
        $model->setLocale($locale);
        $model->save();

        return $model;
    }

    /**
     * Set product variant data
     * @param type $productId
     * @param \SProductVariants $model
     * @param array $data
     * @return \SProductVariants
     */
    private function _setVariantData($productId, $model, array $data) {
        /* @var $model \SProductVariants */
        $model->setProductId($productId);
        $model->setNumber($data['number']);
        $model->setStock($data['stock']);
        $model->setPosition($data['position']);

        if ($data['mainImage'] !== NULL) {
            $model->setMainimage($data['mainImage']);
        }

        if ($data['var_external_id']) {
            $model->setExternalId($data['var_external_id']);
        }
        $model->setCurrency($data['currency']);
        $model->setPriceInMain(str_replace(',', '.', $data['price_in_main']));
        $model->save();

        \Currency\Currency::create()->checkPrices();

        return $model;
    }

    /**
     * Delete product by ID
     * @param int $id
     * @return type
     */
    public function deleteProduct($id) {
        try {

            if (!$id)
                throw new \Exception(lang('You did not specified product id'));

            /** Delete images */
            $this->deleteProductImages($id);
            /** Delete product kits */
            $this->deleteProductKits($id);

            /** Orders delete */
//            $this->deleteProductOrdes($id);

            /** Notifications delete */
            $this->deleteProductNotifications($id);

            /** Delete product */
            $model = \SProductsQuery::create()->findOneById($id);
            if ($model) {
                $model->delete();
            }
            /** End Delete product */
            /** Delete product from users carts */
            $this->deleteProductFromCart($id);

            /* Delete product custom fields data */
            $this->deleteProductCustomFieldsData($id);

            return TRUE;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Delete product custom fields data
     * @param int $product_id - product id
     * @return int
     * @throws \Exception
     */
    public function deleteProductCustomFieldsData($product_id) {
        if (!$product_id)
            throw new \Exception(lang('You did not specified product id'));

        return \CustomFieldsDataQuery::create()->filterByentityId($product_id)->delete();
    }

    /**
     * Delete produtc kits by product ID
     * @param int $product_id
     * @return boolean
     */
    public function deleteProductKits($product_id) {
        if (!$product_id) {
            $this->setError(lang('You did not specified product id'));
            return FALSE;
        }

        $modelKit = \ShopKitQuery::create()
                ->findByProductId($product_id);

        if ($modelKit) {
            $modelKit->delete();
        }

        return TRUE;
    }

    /**
     * Delete product orders by product ID
     * @param int $product_id
     * @return boolean
     */
    public function deleteProductOrdes($product_id) {
        if (!$product_id) {
            $this->setError(lang('You did not specified product id'));
            return FALSE;
        }

        $orders = $this->db
                ->where('product_id', $product_id)
                ->get('shop_orders_products');

        if ($orders) {
            $orders = $orders->result();

            foreach ($orders as $key => $order) {
                $orderId[$key] = $order->order_id;
            }

            $modelOrders = \SOrdersQuery::create()
                    ->findPks($orderId);

            if ($modelOrders) {
                $modelOrders->delete();
            }
        }

        return TRUE;
    }

    /**
     * Delete product notifications by product ID
     * @param int $product_id
     * @return boolean
     */
    public function deleteProductNotifications($product_id) {
        if (!$product_id) {
            $this->setError(lang('You did not specified product id'));
            return FALSE;
        }

        $notifModel = \SNotificationsQuery::create()
                ->findByProductId($product_id);

        if ($notifModel) {
            $notifModel->delete();
        }
        return TRUE;
    }

    /**
     * Delete product images by product ID
     * @param int $product_id
     * @return boolean
     */
    private function deleteProductImages($product_id) {
        if (!$product_id) {
            $this->setError(lang('You did not specified product id'));
            return FALSE;
        }

        \MediaManager\Image::create()
                ->deleteImagebyProductId($product_id)
                ->deleteAdditionalImagebyProductId(array($product_id));

        return TRUE;
    }

    /**
     * Get product properties by ID
     * @param int $product_id
     * @param string $locale
     * @return boolean
     * @throws \Exception
     */
    public function getProductProperties($product_id, $locale = 'ru') {
        try {
            if (!$product_id) {
                throw new \Exception(lang('You did not specified product id'));
            }

            $model = \SProductsQuery::create()->findOneById($product_id);
            if ($model) {
                $categoryId = $model->getCategoryId();

                if ($categoryId) {
                    $categoryModel = \SCategoryQuery::create()->findOneById($categoryId);

                    if ($categoryModel) {

                        $properties = \SPropertiesQuery::create()
                                ->joinWithI18n($locale, Criteria::LEFT_JOIN)
                                ->filterByActive(true)
                                ->filterByShowInCompare(true)
                                ->filterByPropertyCategory($categoryModel)
                                ->orderByPosition()
                                ->find()
                                ->toArray();
                    } else {
                        throw new \Exception(lang('Product category does not exists'));
                    }

                    if ($properties) {
                        return $properties;
                    } else {
                        throw new \Exception(lang('Product has no properties'));
                    }
                } else {
                    throw new \Exception(lang('Product has no category'));
                }
            } else {
                throw new \Exception(lang('Product that you specified does not exist'));
            }
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    /**
     * Set product property value
     * @param int $product_id - product ID
     * @param int $property_id - product property ID
     * @param type $property_value - product property value (can be array if property is multiple)
     * @param string $locale - product property locale
     * @return boolean
     */
    public function setProductPropertyValue($product_id, $property_id, $property_value, $locale = 'ru') {

        if ($product_id && $property_id && $locale) {

            /** Get property from db */
            $property = \SPropertiesQuery::create()
                    ->filterById($property_id)
                    ->findOne();

            if ($property) {

                if (is_array($property_value)) {

                    /** Check if property is multiple selection */
                    if ($property->getMultiple()) {

                        /** Delete all product properties values */
                        $this->deleteProductPropertyValue($product_id, $property_id, $locale);

                        /** Prepare array to insert */
                        foreach ($property_value as $value) {
                            $data[] = array(
                                'product_id' => $product_id,
                                'property_id' => $property_id,
                                'locale' => $locale,
                                'value' => htmlspecialchars($value)
                            );
                        }
                        return $this->db->insert_batch('shop_product_properties_data', $data);
                    } else {
                        $this->setError(lang('Not multiple property cant set few values'));
                        return FALSE;
                    }
                } else {

                    /** Delete all product properties values */
                    $this->deleteProductPropertyValue($product_id, $property_id, $locale);

                    return $this->db->set('product_id', $product_id)
                                    ->set('property_id', $property_id)
                                    ->set('locale', $locale)
                                    ->set('value', htmlspecialchars($property_value))
                                    ->insert('shop_product_properties_data');
                }
            } else {
                $this->setError(lang('Property that you specified does not exist'));
                return FALSE;
            }
        } else {
            $this->setError(lang('Not valid arguments passed to the method'));
            return FALSE;
        }
    }

    /**
     * Delete product property value
     * @param type $product_id product ID
     * @param type $property_id product property ID
     * @param type $locale product property locale
     * @return boolean
     */
    public function deleteProductPropertyValue($product_id, $property_id, $locale = 'ru') {
        if ($product_id && $property_id && $locale) {
            $this->db->where('product_id', $product_id)
                    ->where('property_id', $property_id)
                    ->where('locale', $locale)
                    ->delete('shop_product_properties_data');
            return TRUE;
        } else {
            $this->setError(lang('Not valid arguments passed to the method'));
            return FALSE;
        }
    }

    /**
     * Set product additional categories
     * @param \SProduct $model - product model
     * <br> array $data['additional_categories_ids'] - product additional categories ids
     * @return boolean
     */
    public function setProductAdditionalCategories($model, $data) {
        if ($data['additional_categories_ids'] !== NULL) {
            if ($model && $model instanceof \SProducts) {
                if (is_array($data['additional_categories_ids'])) {

                    $this->db->where('product_id', $model->getId())->delete('shop_product_categories');

                    $insert_data = array();
                    foreach ($data['additional_categories_ids'] as $category_id) {
                        if ($category_id != $model->getCategoryId()) {
                            $insert_data[] = array('product_id' => $model->getId(), 'category_id' => $category_id);
                        }
                    }

                    $insert_data[] = array('product_id' => $model->getId(), 'category_id' => $model->getCategoryId());

                    if (count($insert_data) > 0) {
                        $this->db->insert_batch('shop_product_categories', $insert_data);
                    }
                } else {
                    $this->setError(lang('Additional categories ids must be array'));
                    return FALSE;
                }
                return TRUE;
            } else {
                $this->setError(lang('You did not specified product model'));
                return FALSE;
            }
        } else {
            $this->setError(lang('You did not specified categories array'));
            return FALSE;
        }
    }

    /**
     * Save product additional image
     * @param int $productId - product ID
     * @param string $imageName - image name
     * @param int $position - additional image position
     */
    public function saveProductAdditionalImage($productId, $imageName, $position) {
        if (!$productId) {
            $this->setError(lang('You did not specified product id'));
            return FALSE;
        }

        if (!$imageName) {
            $this->setError(lang('You did not specified image name'));
            return FALSE;
        }

        if (!is_numeric($position)) {
            $this->setError(lang('You did not specified image position'));
            return FALSE;
        }

        $images = $this->db->where('product_id', $productId)->get('shop_product_images')->result_array();
        $same_pos = $this->db->where('product_id', $productId)->where('position', $position)->get('shop_product_images')->row_array();

        if ($same_pos != NULL) {
            $imageForDelete = $same_pos['image_name'];
            \MediaManager\Image::create()->deleteImagebyFullPath(\MediaManager\Image::create()->uploadProductsPath . 'origin/additional/' . $imageForDelete);
            \MediaManager\Image::create()->deleteImagebyFullPath(\MediaManager\Image::create()->uploadProductsPath . 'additional/' . $imageForDelete);
            $this->db->where('product_id', $productId)->where('position', $position)->update('shop_product_images', array('image_name' => $imageName));
        } else {
            if (!$images) {
                $position = 0;
            }

            $data = array(
                'product_id' => $productId,
                'image_name' => $imageName,
                'position' => $position
            );
            $this->db->insert('shop_product_images', $data);
        }

        return TRUE;
    }

    /**
     * Get products by ids
     * 
     * @param array $ids
     * @return \SProducts 
     */
    public function getProducts($ids) {
        if (is_array($ids)) {
            $model = \SProductsQuery::create()->findById($ids);
        } else {
            $model = \SProductsQuery::create()->findOneById($ids);
        }
        return $model;
    }

    /**
     * Delete product from users carts by product ID
     * @param int $product_id - product ID
     * @return boolean
     */
    public function deleteProductFromCart($product_id) {
        if (!$product_id) {
            $this->setError(lang('You did not specified product id'));
            return FALSE;
        }

        /** Get users from DB */
        $users = $this->db->get('users');
        $users = $users ? $users->result_array() : array();

        /** User data to update */
        $usersUpdateData = array();

        /** Prepare user data to update */
        foreach ($users as $user) {
            $cart_data = $user['cart_data'] ? unserialize($user['cart_data']) : array();

            foreach ($cart_data as $key => $cart_item) {
                /** Remove product from cart data */
                if ($cart_item['instance'] == 'SProducts' && $cart_item['productId'] == $product_id) {
                    unset($cart_data[$key]);
                    $usersUpdateData[] = array('id' => $user['id'], 'cart_data' => serialize($cart_data));
                    break;
                }
            }
        }

        /** Update users cart data  */
        if (count($usersUpdateData) > 0) {
            $this->db->update_batch('users', $usersUpdateData, 'id');
        }

        return TRUE;
    }

}

/* End of file product.php _Admin_ ImageCms */
