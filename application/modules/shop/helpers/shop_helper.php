<?php

use Propel\Runtime\ActiveQuery\Criteria;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('promoLabel')) {


    function promoLabel($action, $hot, $hit, $disc) {
        if ($disc >= 100)
            $disc = 99;
        $pricePrecision = ShopCore::app()->SSettings->pricePrecision;
        $out = "";

        if ($action && (int) $action > 0)
            $out .= '<span class="product-status action"></span>';
        if ($hot && (int) $hot > 0)
            $out .= '<span class="product-status nowelty"></span>';
        if ($hit && (int) $hit > 0)
            $out .= '<span class="product-status hit"></span>';
        if ($disc && (float) $disc > 0)
            $out .= '<span class="product-status discount"><span class="text-el">' . round($disc, 0) . '%</span></span>';
        return $out;
    }

}
if (!function_exists('promoLabelBtn')) {

    function promoLabelBtn($action, $hot, $hit, $disc) {
        $out = array();
        if ($action && (int) $action > 0)
            $out['action'] = $action;
        if ($hot && (int) $hot > 0)
            $out['hot'] = $hot;
        if ($hit && (int) $hit > 0)
            $out['hit'] = $hit;
        if ($disc && (float) $disc > 0)
            $out['disc'] = round($disc, 0);

        return $out;
    }

}

if (!function_exists('getAmountInCart')) {

    /**
     * Checks if product/kit is in cart already
     * @param string $instance
     * @param int $id
     * @return int 0 if product is not in cart, or quantity in cart 
     */
    function getAmountInCart($instance, $id) {
        $items = \Cart\BaseCart::getInstance()->getItems();
        foreach ($items['data'] as $itemData) {
            if ($itemData->instance == $instance & $itemData->id == $id) {
                return $itemData->quantity;
            }
        }
        return 0;
    }

}
if (!function_exists('isExistsItems')) {

    /**
     * Сhecking exists items
     * @param string $instance SProducts|ShopKit
     * @param int $id id of product|kit
     * @return boolean 
     */
    function isExistsItems($instance, $id) {

        $ci = &get_instance();
        if ($instance == 'SProducts')
            return $ci->db->where('id', $id)->get('shop_product_variants')->num_rows();


        if ($instance == 'ShopKit')
            return count($ci->db->where('id', $id)->get('shop_kit')->num_rows());
    }

}

if (!function_exists('getCartItems')) {

    /**
     * Сhecking exists items
     * @param string $instance SProducts|ShopKit
     * @param int $id id of product|kit
     * @return boolean 
     */
    function getCartItems($instance, $id) {

        $items = \Cart\BaseCart::getInstance()->getItems();
        foreach ($items['data'] as $itemData) {
            if ($itemData->instance == $instance & $itemData->id == $id) {
                return $itemData;
            }
        }
        return 0;
    }

}

if (!function_exists('checkStock')) {

    /**
     * Сhecking quantities in stock (if enabled)
     * @param string $instance SProducts|ShopKit
     * @param int $id id of product|kit
     * @param int $quantity (optional) needed amount
     * @return boolean 
     */
    function isAviableInStock($instance, $id, $quantity = 1) {
        // get settings
        $ordersCheckStocks = (boolean) ShopSettingsQuery::create()
                        ->filterByName('ordersCheckStocks')
                        ->findOne()->getValue();

        if ($ordersCheckStocks == FALSE) {
            return TRUE;
        }

        /* @var $ci MY_Controller */
        $ci = &get_instance();

        // FOR PRODUCT
        if ($instance == "SProducts") {
            $result = $ci->db
                    ->select('stock')
                    ->where('id', $id)
                    ->get('shop_product_variants')
                    ->row_array();
            $stock = $result['stock'];
            return ($stock > 0 & $stock >= $quantity) ? TRUE : FALSE;
        }

        // FOR KIT 
        if ($instance == "ShopKit") {
            // first is gathering of all products of kit
            // main product
            $result = $ci->db->select('product_id, active')->where('id', $id)->get('shop_kit')->row_array();
            if ($result['active'] != 1) {
                return FALSE;
            }
            $productIds = array($result['product_id']);
            // additional products
            $result = $ci->db->select('product_id')->where('kit_id', $id)->get('shop_kit_product')->result_array();
            foreach ($result as $row) {
                $productIds[] = $row['product_id'];
            }

            // getting first variants ids of all products
            $variantIds = $ci->db
                    ->select('stock')
                    ->where_in('product_id', $productIds)
                    ->order_by('position', 'ASC')
                    ->group_by('id')
                    ->get('shop_product_variants')
                    ->result_array();

            // checking stock of every product
            foreach ($variantIds as $row) {
                if (!($row['stock'] > 0 & $row['stock'] >= $quantity))
                    return FALSE;
            }

            return TRUE;
        }

        return FALSE;
    }

}




if (!function_exists('shop_url')) {

    function shop_url($url) {
        if (empty($url))
            return '/';
        return site_url('shop/' . $url);
    }

}

if (!function_exists('productMainImageUrl')) {

    function productMainImageUrl($model) {
        if ($model->MainImage != null)
            $name = $model->MainImage;
        elseif ($model->SProducts->MainImage != null)
            $name = $model->SProducts->MainImage;

        return (!empty($name)) ? media_url('uploads/shop/' . $name) : media_url('uploads/shop/nophoto/nophoto.jpg');
    }

}
if (!function_exists('productSmallImageUrl')) {

    function productSmallImageUrl($model) {

        if ($model->firstVariant->getSmallImage() != null) {
            $name = $model->firstVariant->getSmallImage();
        } elseif ($model->firstVariant->getMainImage() != null) {
            $name = $model->firstVariant->getMainImage();
        }
        return (!empty($name)) ? media_url('uploads/shop/' . $name) : media_url('uploads/shop/nophoto/nophoto.jpg');
    }

}

if (!function_exists('productImageUrl')) {

    function productImageUrl($name, $useRand = FALSE) {
        $rand = ($useRand === TRUE) ? ('?' . rand(1, 1000)) : null;
        return (!empty($name)) ? media_url('uploads/shop/' . $name . $rand) : media_url('uploads/shop/nophoto/nophoto.jpg' . $rand);
    }

}

if (!function_exists('getAddti')) {

    function productThumbUrl($name, $useRand = false) {
        return media_url('uploads/shop/additionalImageThumbs/' . $name);
    }

}

/**
 * @deprecated since version number 4.2+
 */
if (!function_exists('renderCategoryPath')) {

    function renderCategoryPath(SCategory $model) {
        $path = $model->buildCategoryPath();
        $size = sizeof($path);

        echo '<div xmlns:v="http://rdf.data-vocabulary.org/#" class="crumbs">' . "\n";
        if ($size > 0) {
            echo '<span typeof="v:Breadcrumb">' . anchor('', lang('Home'), 'property="v:title" rel="v:url"') . '</span>';
            echo ' /  ';

            $n = 0;
            foreach ($path as $category) {
                echo '<span typeof="v:Breadcrumb">' . anchor(shop_url('category/' . $category->getFullPath()), ShopCore::encode($category->getName()), 'property="v:title" rel="v:url"') . '</span>';
                if ($n < $size - 1)
                    echo ' /  ';
                $n++;
            }
        }
        else {
            echo '<span typeof="v:Breadcrumb">' . anchor('', ShopCore::$ci->core->settings['site_short_title'], 'property="v:title" rel="v:url"') . '</span>';
            echo ' →  ';
            echo '<span typeof="v:Breadcrumb">' . anchor(shop_url('category/' . $model->getFullPath()), ShopCore::encode($model->getName()), 'property="v:title" rel="v:url"') . '</span>';
        }
        echo '</div>';
    }

}
if (!function_exists('countRating')) {

    function countRating($productId) {
        $rating = SProductsRatingQuery::create()->findPk($productId);
        if ($rating !== null)
            $rating = round($rating->getRating() / $rating->getVotes());
        else
            $rating = 0;

        return $rating;
    }

}

if (!function_exists('renderCategoryPathNoSeo')) {

    function renderCategoryPathNoSeo(SCategory $model) {
        $path = $model->buildCategoryPath();
        $size = sizeof($path);

        if ($size > 0) {
            echo anchor('', ShopCore::t(lang('Home')));
            echo ' /  ';

            $n = 0;
            foreach ($path as $category) {
                echo anchor(shop_url('category/' . $category->getFullPath()), ShopCore::encode($category->getName()));
                if ($n < $size - 1)
                    echo ' /  ';

                $n++;
            }
        }
        else {
            echo anchor('shop', ShopCore::t(lang('Home')));
            echo ' /  ';
            echo anchor(shop_url('category/' . $model->getFullPath()), ShopCore::encode($model->getName()));
        }
    }

}

if (!function_exists('is_property_in_get')) {

    function is_property_in_get($pId, $index) {
        if (isset(ShopCore::$_GET['f'][$pId]) && in_array($index, ShopCore::$_GET['f'][$pId])) {
            return true;
        }

        return false;
    }

}

if (!function_exists('get_currencies')) {

    function get_currencies() {
        return SCurrenciesQuery::create()->find();
    }

}

// For Windows
if (!function_exists('money_format')) {

    function money_format($format, $price) {
        return round($price, ShopCore::app()->SSettings->pricePrecision);
    }

}

if (!function_exists('getDefaultLanguage')) {

    /**
     * Get default language
     */
    function getDefaultLanguage() {
        $ci = get_instance();
        $ci->db->cache_on();
        $languages = $ci->db
                ->where('default', 1)
                ->get('languages');

        if ($languages)
            $languages = $languages->row_array();
        $ci->db->cache_off();

        return $languages;
    }

}

if (!function_exists('setCurentLanguage')) {

    /**
     * Get default language
     */
    function setDefaultLanguage($model) {
        $curentLanguage = getDefaultLanguage();
        $curentLanguage = $curentLanguage['identif'];
        $model->setLocale($curentLanguage);
    }

}

if (!function_exists('setCurentLanguage')) {

    /**
     * Get default language
     */
    function setDefaultLanguage1($model) {
        $curentLanguage = getDefaultLanguage();
        $curentLanguage = $curentLanguage['identif'];
        $model->setLocale($curentLanguage);
    }

}

if (!function_exists('getPromoBlock')) {

    function getPromoBlock($type = 'action', $limit = 10, $idCategory = NULL, $idBrand = NULL) {



        $model = SProductsQuery::create()
                ->joinWithI18n(ShopController::getCurrentLocale())
                ->orderByCreated('DESC');
        if ($idCategory) {
            $model = $model->filterByCategoryId($idCategory);
        }
        if ($idBrand) {
            $model = $model->filterByBrandId($idBrand);
        }
        if (strpos($type, 'hit'))
            $model = $model->_or()->filterByHit(true);
        if (strpos($type, 'hot'))
            $model = $model->_or()->filterByHot(true);
        if (strpos($type, 'action'))
            $model = $model->_or()->filterByAction(true);
        if (strpos($type, 'oldPrice'))
            $model = $model->_or()->filterByOldPrice(true);
        if (strpos($type, 'category') AND ( $categoryId = filterCategoryId()) !== false)
            $model = $model->useShopProductCategoriesQuery()->filterByCategoryId($categoryId)->endUse();
        if (strpos($type, 'popular')) {
            
        }
        // $model = $model->where('SProducts.Views > ?', 1)->orderByViews(Criteria::DESC);
        if (strpos($type, 'date'))
            $model = $model->orderByUpdated(Criteria::DESC);
        $model = $model->filterByActive(true)->limit($limit)->find();

        return $model;
    }

}

function filterCategoryId() {

    $CI = & get_instance();
    $core_data = $CI->core->core_data;
    if ($core_data['data_type'] == 'product') {

        $productId = $core_data['id'];
        $CI->db->cache_on();
        $CI->db->select('shop_category.id');
        $CI->db->from('shop_category');
        $CI->db->join('shop_products', 'shop_products.category_id = shop_category.id');
        $CI->db->where('shop_products.id', $productId);
        $query = $CI->db->get()->result_array();
        $CI->db->cache_off();

        $idCategory = (int) $query[0]['id'];
    } elseif ($core_data['data_type'] == 'shop_category') {
        $idCategory = (int) $core_data['id'];
    } else {
        $idCategory = (bool) false;
    }
    return $idCategory;
}

if (!function_exists('productInCart')) {

    function productInCart(&$haystack, $prodId, $varProdId, $stock = 1) {
        $response = array(
            array('message' => lang('Buy'), 'class' => 'button_gs', 'identif' => 'goBuy', 'link' => shop_url('product/' . $prodId)),
            array('message' => lang('Formulation <br/> order'), 'class' => 'button_middle_blue', 'identif' => 'goToCart', 'link' => '/shop/cart'),
            array('message' => 'Сообщить <br />о появлении', 'class' => 'button_greys', 'identif' => 'goNotifMe', 'link' => shop_url('product/' . $prodId)));
        if (!$stock) {
            return $response[2];
            exit();
        }
        if (!isset($haystack['SProducts_' . $prodId . '_' . $varProdId]))
            return $response[0];
        else
            return $response[1];
    }

}

if (!function_exists('productInCartI')) {

    function productInCartI(&$haystack, $prodId, $varProdId, $stock = 1) {
        $response = array(
            array('message' => lang('Buy'), 'class' => 'buttons button_big_green', 'identif' => 'goBuy', 'link' => '#'),
            array('message' => lang('Formulation order'), 'class' => 'buttons button_big_blue', 'identif' => 'goToCart', 'link' => '/shop/cart'),
            array('message' => lang('Announce a'), 'class' => 'buttons button_big_greys', 'identif' => 'goNotifMe', 'link' => shop_url('product/' . $prodId)));
        if (!$stock) {
            return $response[2];
            exit();
        }
        if (!isset($haystack['SProducts_' . $prodId . '_' . $varProdId]))
            return $response[0];
        else
            return $response[1];
    }

}
/**
 * @deprecated since version number 4.2+
 */
if (!function_exists('getLimiPrice')) {

    function getLimiPrice($cat_id, $way = 'min') {
        $CI = &get_instance();

        $child_cats = SCategoryQuery::create()
                ->where('SCategory.ParentId = ?', $cat_id)
                ->select(array('Id'))
                ->find()
                ->toArray();
        $additional_goods = $CI->db->select('product_id')->where('category_id', $cat_id)->get('shop_product_categories')->result_array();
        $add_filter = array();
        foreach ($additional_goods as $item) {
            array_push($add_filter, $item['product_id']);
        }
        array_push($child_cats, $cat_id);
        if ($way == 'min') {
            $min_price = SProductsQuery::create()
                    ->leftJoin('ProductVariant')
                    ->filterByCategoryId($child_cats)
                    ->filterByActive(true)
                    ->select(array('ProductVariant.PriceInMain'))
                    ->limit(1)
                    ->orderBy('ProductVariant.PriceInMain', Criteria::ASC)
                    ->find()
                    ->toArray();
            if (count($add_filter) > 0)
                $min_price_2 = $CI->db->where_in('product_id', $add_filter)->order_by('price_in_main')->limit(1)->get('shop_product_variants')->row_array();

            if ($min_price[0] > $min_price_2['price_in_main'])
                $min_price[0] = $min_price_2['price_in_main'];
        } else {
            $min_price = SProductsQuery::create()
                    ->leftJoin('ProductVariant')
                    ->filterByCategoryId($child_cats)
                    ->filterByActive(true)
                    ->select(array('ProductVariant.Price'))
                    ->limit(1)
                    ->orderBy('ProductVariant.Price', Criteria::DESC)
                    ->find()
                    ->toArray();
            if (count($add_filter) > 0)
                $min_price_2 = $CI->db->where_in('product_id', $add_filter)->order_by('price_in_main', 'desc')->limit(1)->get('shop_product_variants')->row_array();

            if ($min_price[0] < $min_price_2['price_in_main'])
                $min_price[0] = $min_price_2['price_in_main'];
        }
        return round($min_price[0], 0);
    }

}
/**
 * @deprecated since version number 4.2+
 */
if (!function_exists('getLimitAllPrice')) {

    function getLimitAllPrice($way = 'min') {

        if ($way == 'min') {
            $min_price = SProductsQuery::create()
                    ->leftJoin('ProductVariant')
                    ->filterByActive(true)
                    ->select(array('ProductVariant.Price'))
                    ->limit(1)
                    ->orderBy('ProductVariant.Price', Criteria::ASC)
                    ->find()
                    ->toArray();
        } else {
            $min_price = SProductsQuery::create()
                    ->leftJoin('ProductVariant')
                    ->filterByActive(true)
                    ->select(array('ProductVariant.Price'))
                    ->limit(1)
                    ->orderBy('ProductVariant.Price', Criteria::DESC)
                    ->find()
                    ->toArray();
        }

        return round($min_price[0], 0);
    }

}
if (!function_exists('is_in_cart')) {

    function is_in_cart($id) {
        $result = ShopCore::app()->SCart->getData();
        if ($result) {
            $res = 0;
            foreach ($result as $item) {
                if ($item['productId'] == $id) {
                    $res = 1;
                }
            }
        }
        return $res;
    }

}
if (!function_exists('is_in_wish')) {

    function is_in_wish($id) {
        $result = ShopCore::app()->SWishList->getData();
        if ($result) {
            $res = 0;
            foreach ($result as $item) {
                if ($item[0] == (int) $id) {
                    $res = 1;
                }
            }
        }
        return $res;
    }

}

function getProduct($id) {
    return SProductsQuery::create()
                    ->joinWithI18n(MY_Controller::getCurrentLocale())
                    ->findPk($id);
}

//Simular Function-------------------------------

if (!function_exists('getSimilarProduct')) {

    function getSimilarProduct($model, $limit = 8) {
        $currentLocale = ShopController::getCurrentLocale();
        $vpOne = $model->firstVariant->PriceInMain;

        $max = ($vpOne + $vpOne / 100 * 20);
        $min = ($vpOne - $vpOne / 100 * 20);

        $product = SProductsQuery::create()
                ->filterById($model->getId(), Criteria::ALT_NOT_EQUAL)
                ->joinWithI18n($currentLocale)
                ->filterByCategoryId($model->getCategoryId())
                ->filterByActive(true)
                ->useProductVariantQuery()
                ->filterByPriceInMain(array('min' => $min, 'max' => $max))
                ->endUse()
                ->distinct()
                ->limit($limit)
                ->find();

        return $product;
    }

}

//Simular Function END----------------------------

if (!function_exists('get_lang_admin_folders')) {

    function getVariant($pid, $vid) {
        return SProductVariantsQuery::create()->joinWithI18n(ShopController::getCurrentLocale())->filterByProductId($pid)->filterById($vid)->findOne();
    }

}

if (!function_exists('currency_convert')) {

    function currency_convert($val, $currencyId) {
        $currentCurrency = \Currency\Currency::create()->current;
        $nextCurrency = \Currency\Currency::create()->additional;
        if ($currencyId == Null) {
            $currencyId = $currentCurrency->getId();
        }
        if ($currentCurrency->getId() == $currencyId) {
            $result['main']['price'] = $val;
            if (count(\Currency\Currency::create()->getCurrencies()) > 1) {
                $result['second']['price'] = \Currency\Currency::create()->convertnew($val, $nextCurrency->getId());
            }
        } else {
            $result['main']['price'] = \Currency\Currency::create()->convert($val, $currencyId);
            if (count(\Currency\Currency::create()->getCurrencies()) > 1) {
                if ($nextCurrency->getId() == $currencyId)
                    $result['second']['price'] = $val;
                else
                    $result['second']['price'] = \Currency\Currency::create()->convertnew($result['main']['price'], $nextCurrency->getId());
            }
        }
        $result['main']['symbol'] = $currentCurrency->getSymbol();
        if (count(\Currency\Currency::create()->getCurrencies()) > 1) {
            $result['second']['symbol'] = $nextCurrency->getSymbol();
        }
        return $result;
    }

}

if (!function_exists('count_star')) {

    function count_star($rate) {
        switch ($rate) {
            case 0:
                $result = 'nostar';
                break;
            case 1:
                $result = 'onestar';
                break;
            case 2:
                $result = 'twostar';
                break;
            case 3:
                $result = 'threestar';
                break;
            case 4:
                $result = 'fourstar';
                break;
            case 5:
                $result = 'fivestar';
                break;
            default :
                $result = 'nosrtar';
        }
        echo $result;
    }

}

if (!function_exists('getVariants')) {

    function getVariants($productId) {
        if ($productId != Null) {
            $CI = & get_instance();
            return $CI->db->query("SELECT * FROM `shop_product_variants` JOIN `shop_product_variants_i18n` ON shop_product_variants.id=shop_product_variants_i18n.id WHERE locale='" . ShopController::getCurrentLocale() . "' AND `product_id`=" . $productId)->result();
        }
    }

}

if (!function_exists('var_dumps')) {

    function var_dumps($args) {
        $args = func_num_args() === 1 ? array_shift(func_get_args()) : func_get_args();
        if (!CI::$APP->input->is_ajax_request()) {
//        if (TRUE || !CI::$APP->input->is_ajax_request()) {
            Symfony\Component\VarDumper\VarDumper::dump($args);
        } else {
            echo '<pre>';
            echo var_dump($args);
            echo '</pre>';
        }
    }

}

if (!function_exists('var_dumps_exit')) {

    function var_dumps_exit() {
        $args = func_num_args() === 1 ? array_shift(func_get_args()) : func_get_args();
        var_dumps($args);
        exit;
    }

}

if (!function_exists('dd')) {

    function dd($arg) {
        var_dumps_exit($arg);
        exit;
    }

}

if (!function_exists('searchResultsInCategories')) {

    function searchResultsInCategories($tree, $categorys) {
        foreach ($tree as $item) {
            if ($item->getLevel() == "0") {
                $id_0 = $item->getId();
                $cat[0][$item->getId()][name] = $item->getName();
                $cat[0][$item->getId()][count] = $categorys[$item->getId()];
                $cat[$id_0][$id_1][childs] = 0;
            } elseif ($item->getLevel() == "1") {
                if ($categorys[$item->getId()]) {
                    $cat[0][$id_0][childs] ++;
                }

                $id_1 = $item->getId();
                $cat[$id_0][$item->getId()][name] = $item->getName();
                $cat[$id_0][$item->getId()][count] = $categorys[$item->getId()];
                $cat[$id_0][$id_1][childs] = 0;
            } else {
                if ($categorys[$item->getId()]) {
                    $cat[0][$id_0][childs] ++;
                    $cat[$id_0][$id_1][childs] ++;
                    $cat[$id_1][$item->getId()][name] = $item->getName();
                    $cat[$id_1][$item->getId()][count] = $categorys[$item->getId()];
                    $cat[$id_1][$item->getId()][id] = $item->getId();
                }
            }
        }
        return $cat;
    }

}


if (!function_exists('html_wraper')) {

    function html_wraper($data, $template, $delimiter = '', $item_delimeter = '') {

        $result = "";

        foreach ($data as $key => $value) {
            $pre = "";
            $after = "";

            foreach ($template[0] as $t_key => $t_value) {
                $pre .= "<" . $t_key . " " . http_build_query($t_value, '', ' ') . ">";
                $after .= "</" . $t_key . ">";
            }

            if (is_array($value)) {
                $item_value = $pre . implode(', ', $value) . $after;
            } else {
                $item_value = $pre . $value . $after;
            }

            $pre = "";
            $after = "";

            if ($key) {
                if ($template[1]) {
                    foreach ($template[1] as $t_key => $t_value) {
                        $pre .= "<" . $t_key . " " . http_build_query($t_value, '', ' ') . ">";
                        $after .= "</" . $t_key . ">";
                    }
                    $item_key = $pre . $key . $delimiter . $after;
                } else {
                    $item_key .= $key . $delimiter;
                }
            } else {
                $item_key = "";
            }

            $result .= $item_key . $item_value . $item_delimeter;
        }
        return $result;
    }

}
if (!function_exists('getCountOrders')) {

    function getCountOrders($status = null) {


        $Orders = SOrdersQuery::create();

        return ($status === null) ? $Orders->count() : $Orders->filterByStatus($status)->count();
    }

}
if (!function_exists('getCountProductNotify')) {

    function getCountProductNotify() {


        return SNotificationsQuery::create()->count();
    }

}
