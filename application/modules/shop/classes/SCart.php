<?php

use Propel\Runtime\ActiveQuery\Criteria;

/**
 * SCart class file
 *
 * @package Shop
 * @copyright 2012 Siteimage
 * @author <dev
 */
class SCart {

    protected $model; // SProducts|ShopKit model.
    public $quantityMax = 10; // TODO: load maxRange value from database setting.
    public $sessKey = 'ShopCartData'; // Session key to store cart items list.

    public function __construct() {
        
    }

    /**
     * Add product to cart.
     *
     * @param array $data Product Data
     *
     * array(SProducts model,variantId,quantity)
     *
     * @access public
     * @return bool
     */
    public function add($data = array()) {


        $data = (object) $data;

        if ($data->model instanceof SProducts) {
            $productVariants = $data->model->getProductVariants();

            $variant = null;
            foreach ($productVariants as $v) {
                if ($v->getId() == $data->variantId) {
                    $variant = $v;
                }
            }

            if ($variant === null)
                return false;

            $itemData = array(
                'instance' => 'SProducts',
                'productId' => $data->model->getId(),
                'variantId' => $variant->getId(),
                'quantity' => $data->quantity,
                'price' => number_format($variant->getPrice(), ShopCore::app()->SSettings->pricePrecision,'.', '')
            );

            $this->_addToCart($itemData);
        } elseif ($data->model instanceof ShopKit) {

            $itemData = array(
                'instance' => 'ShopKit',
                'kitId' => $data->model->getId(),
                'quantity' => $data->quantity,
                'price' => in_array('getPrice', get_class_methods(get_class($data->model))) ? $data->model->getPrice() : \Currency\Currency::create()->toMain($data->model->getTotalPrice()),
            );



            $this->_addToCart($itemData);
        }
    }

    /**
     * Add product to session data.
     *
     * @param array $data
     * @access protected
     * @return bool always returns true
     */
    protected function _addToCart($data) {
        $sessionData = $this->getData();

        if ($data['instance'] == 'SProducts') {
            $key = $data['instance'] . '_' . $data['productId'] . '_' . $data['variantId'];

            if ($data['quantity'] < 1)
                $data['quantity'] = 1;

            if (array_key_exists($key, $sessionData)) {
                $data['quantity'] = $sessionData[$key]['quantity'] + $data['quantity'];

                //Check quantity
                if ($sessionData[$key]['quantity'] >= $this->quantityMax)
                    $data['quantity'] = $this->quantityMax;
            }

            if ($data['variantId'] > 0) {
                $variant = SProductVariantsQuery::create()
                        ->joinWithI18n(MY_Controller::getCurrentLocale())
                        ->filterByProductId($data['productId'])
                        ->findPk($data['variantId']);

                if ($variant) {
                    $data['variantName'] = ShopCore::encode($variant->getName());
                } else {
                    $data['variantName'] = FALSE;
                }
            }
        } elseif ($data['instance'] == 'ShopKit') {

            $key = $data['instance'] . '_' . $data['kitId'];

            if ($data['quantity'] < 1)
                $data['quantity'] = 1;

            if (array_key_exists($key, $sessionData)) {
                $data['quantity'] = $sessionData[$key]['quantity'] + $data['quantity'];

                //Check quantity
                if ($sessionData[$key]['quantity'] >= $this->quantityMax)
                    $data['quantity'] = $this->quantityMax;
            }
        }

        $sessionData[$key] = $data;
        $this->setData($sessionData);

        return true;
    }

    /**
     * Remove all items.
     *
     * @access public
     * @return void
     */
    public function removeAll() {
        // Set user cart data if logged in
        if (ShopCore::$ci->dx_auth->is_logged_in() === true) {
            $sUserData = SUserProfileQuery::create()->filterById(ShopCore::$ci->dx_auth->get_user_id())->findOne();
            $sUserData->setCartData(null);
            $sUserData->save();
        }
        else
            ShopCore::$ci->session->set_userdata($this->sessKey, false);
    }

    public function removeOne($key) {
        $data = $this->getData();
        \CMSFactory\Events::create()->registerEvent($data[$key]);
        if (isset($data[$key]))
            unset($data[$key]);
        $this->setData($data);
        return true;
    }

    /**
     * Get total items count.
     *
     * @access public
     * @return integer
     */
    public function totalItems() {
        $total = 0;
        $data = $this->getData();

        foreach ($data as $item)
            $total += $item['quantity'];

        return $total;
    }

    /**
     * Get total price.
     *
     * @access public
     * @return float
     */
    public function totalPrice($converToCurrent = true) {
        $data = $this->getData();
        $result = 0;

        if (sizeof($data) > 0) {
            foreach ($data as $item) {
                $result += $item['price'] * $item['quantity'];
            }
        }

        if ($converToCurrent === true)
            $result = \Currency\Currency::create()->convert($result);

        return round($result, ShopCore::app()->SSettings->pricePrecision);
    }

    /**
     * Recount items quantity from post.
     *
     * @access public
     * @return void
     */
    public function recount() {
//        if (ShopCore::app()->SDiscountsManager->__construct() !== FALSE) {
//            ShopCore::app()->SDiscountsManager->recountDiscount($this);
//        } else {
        $newData = array();
        $data = $this->getData();
        
        $products = $this->loadProducts();

        $key = 0;
        foreach ($data as $key => $item) {
            echo $key . ' ';
            
            if (isset($_POST['products'][$key]) && $_POST['products'][$key] > 0) {
                $item['quantity'] = (int) $_POST['products'][$key];
            } elseif (isset($_POST['kits'][$key]) && $_POST['kits'][$key] > 0) {
                $item['quantity'] = (int) $_POST['kits'][$key];
            }
            else
                $item['quantity'] = 1;
            
            /** Check count products if true **/
            if (ShopCore::app()->SSettings->ordersCheckStocks)
                $item['quantity'] = (int) $_POST['products'][$key] <= $products[$key]['model']->firstVariant->getstock() ? $_POST['products'][$key] : $products[$key]['model']->firstVariant->getstock();
            else
                $item['quantity'] = (int) $_POST['products'][$key];
            
            
            // Product delivery price fix
            if (isset($_POST['met_del']) && $_POST['met_del'] > 0) {
                $DeliveryData = SDeliveryMethodsQuery::create()
                        ->filterById($_POST['met_del'])
                        ->findOne();

                $item['delivery_price'] = $DeliveryData->getPrice();
                $item['delivery_free_from'] = $DeliveryData->getFreeFrom();
            }
//                if (isset($_POST['giftcert'])) {
//                    $giftCertUsage = SOrdersQuery::create()
//                            ->filterByGiftCertKey($_POST['giftcert'])
//                            ->find();
//                    if (count($giftCertUsage) == 0) {
//                        $gift_cert_price = ShopGiftsQuery::create()->filterByKey($_POST['giftcert'])->findOne();
//                        if ($gift_cert_price) {
//                            $gift_cert_price = $gift_cert_price->getPrice();
//                        }
//                        $price_sum = $this::totalPrice() - $gift_cert_price;
//
//                        if (isset($_POST['giftcert']) && ($price_sum >= 0)) {
//                            $gift = ShopGiftsQuery::create()->filterByKey($_POST['giftcert'])->findOne();
//                            if ($gift) {
//                                if ($gift->getActive() == 1) {
//                                    $item['gift_code'] = $gift->getKey();
//                                    $item['gift_cert_price'] = $gift->getPrice();
//                                }
//                            }
//                        }
//                    }
//                }
            $newData[$key] = $item;
            $key++;
        }
        $this->setData($newData);
        return $item;
//        }
//        return 0;
    }

    public function apiRecount() {
        $data = $this->getData();
        $keys = array_keys($_POST['products']);

        if (isset($data[$keys[0]]) && $_POST['products'][$keys[0]] > 0) {

            $products = $this->loadProducts();

            $item = $data[$keys[0]];
            if (ShopCore::app()->SSettings->ordersCheckStocks)
                $item['quantity'] = (int) $_POST['products'][$keys[0]] <= $products[$keys[0]]['model']->firstVariant->getstock() ? $_POST['products'][$keys[0]] : $products[$keys[0]]['model']->firstVariant->getstock();
            else
                $item['quantity'] = (int) $_POST['products'][$keys[0]];

            $data[$keys[0]] = $item;
        }

        $keys = array_keys($_POST['kits']);
        if (isset($data[$keys[0]])) {

            $products = $this->loadProducts();
            $item = $data[$keys[0]];
            $item['quantity'] = (int) $_POST['kits'][$keys[0]];

            $data[$keys[0]] = $item;
        }

        $this->setData($data);

        return $item? : false;
    }

    /**
     * Get session data
     *
     * @access public
     * @return array
     */
    public function getData() {
        // Get user cart data if logged in
        if (ShopCore::$ci->dx_auth->is_logged_in() === true) {
            $sUserData = SUserProfileQuery::create()->filterById(ShopCore::$ci->dx_auth->get_user_id())->findOne();
            if ($sUserData != null)
                $data = unserialize($sUserData->getCartData());
        }
        else {
            $data = ShopCore::$ci->session->userdata($this->sessKey);
        }
        if ($data === false or $data === null)
            return array();
        else {
            return $data;
        }
    }

    protected function setData(array $data) {
        // Set user cart data if logged in
        if (ShopCore::$ci->dx_auth->is_logged_in() === true) {
            $sUserData = SUserProfileQuery::create()->filterById(ShopCore::$ci->dx_auth->get_user_id())->findOne();
            $sUserData->setCartData(serialize($data));
            $sUserData->save();
        }
        else
            ShopCore::$ci->session->set_userdata($this->sessKey, $data);
    }

    /**
     * Load products from $this->getData ids array.
     *
     * @access public
     * @return void
     */
    public function loadProducts() {
        $data = $this->getData();

        if (empty($data))
            return array();
        else {
            $newData = array();
            $newCollection = array();
            $ids = array_map("array_shift", $data);
            //$ids = array();
            $orderAmount = 0;
            foreach ($data as $key => $value) {
                if ($value['instance'] == 'SProducts')
                    $ids[$value['instance']][$key] = $value['productId'];
                elseif ($value['instance'] == 'ShopKit')
                    $ids[$value['instance']][$key] = $value['kitId'];
            }

            if (sizeof($ids['SProducts']) > 0 || sizeof($ids['ShopKit']) > 0) {
                if (sizeof($ids['SProducts']) > 0) {
                    // Load products
                    $collection = SProductsQuery::create()
                            ->joinWithI18n(MY_Controller::getCurrentLocale(), Criteria::LEFT_JOIN)
                            ->findPks(array_unique($ids['SProducts']));
                }
                if (sizeof($ids['ShopKit']) > 0) {
                    $kitCollection = ShopKitQuery::create()
                            ->filterByActive(TRUE)
                            ->findPks(array_unique($ids['ShopKit']));
                }
            }
            else
                return false;

            for ($i = 0; $i < sizeof($collection); $i++) {
                $newCollection['SProducts'][$collection[$i]->getId()] = $collection[$i];
            }

            for ($i = 0; $i < sizeof($kitCollection); $i++) {
                $newCollection['ShopKit'][$kitCollection[$i]->getId()] = $kitCollection[$i];
            }

            foreach ($data as $key => $item) {
                if ($item['instance'] == 'SProducts') {
                    if ($newCollection['SProducts'][$item['productId']] !== null) {
                        $item['model'] = $newCollection['SProducts'][$item['productId']];
                        $orderAmount += $item['totalAmount'] = round($item['price'] * $item['quantity'], ShopCore::app()->SSettings->pricePrecision);
                        $newData[$key] = $item;
                    }
                } elseif ($item['instance'] == 'ShopKit') {
                    if ($newCollection['ShopKit'][$item['kitId']] !== null) {
                        $item['model'] = $newCollection['ShopKit'][$item['kitId']];
                        $orderAmount += $item['totalAmount'] = round($item['price'] * $item['quantity'], ShopCore::app()->SSettings->pricePrecision);
                        $newData[$key] = $item;
                    }
                }
                $newData[$key]['orderAmount'] = $orderAmount;
            }
//            var_dumps($newData);exit;
            return $newData;
        }
    }

    public function transferCartData() {
        $data = ShopCore::$ci->session->userdata($this->sessKey);
        if (count($data) > 0 && is_array($data)) {
            foreach ($data as $key => $value) {
                $model = SProductsQuery::create()->findPk((int) $value['productId']);
                $this->add(array(
                    'model' => $model,
                    'variantId' => (int) $value['variantId'],
                    'quantity' => (int) $value['quantity'],
                ));
            }
        }
    }

}
