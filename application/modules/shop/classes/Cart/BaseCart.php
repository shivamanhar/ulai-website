<?php

namespace Cart;

/**
 * 
 *
 * @author DevImageCms
 */
class BaseCart extends \ShopController {

    const MIN_ORDER_PRICE = 1;

    /**
     *
     * @var BaseCart 
     */
    private static $instance;

    /**
     * Items of cart - instances of CartItem
     * @var array 
     */
    protected $items = array();

    /**
     * price without discount
     * @var float 
     */
    protected $originPrice;

    /**
     * price with discount
     * @var float 
     */
    protected $price;

    /**
     * data of  storage
     * @var IDataStorage
     */
    protected $dataStorage;

    /**
     * Total items in cart
     * @var int 
     */
    protected $totalItems;

    /** Errors messages */
    protected $errorMessages = null;

    /**
     * @return BaseCart 
     */
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new BaseCart();
        }
        return self::$instance;
    }

    /**
     * __construct
     */
    public function __construct() {

        if (!self::$instance) {
            parent::__construct();
            $this->dataStorage = $this->getStorage();
            try {
                $itemsArray = $this->dataStorage->getData();
                foreach ($itemsArray as $itemData) {

                    // for capability
                    switch ($itemData['instance']) {
                        case "ShopKit":
                            $itemData['id'] = $itemData['id'] ? $itemData['id'] : $itemData['kitId'];
                            break;
                        case "SProducts":
                            $itemData['id'] = $itemData['id'] ? $itemData['id'] : $itemData['variantId'];
                            break;
                    }

                    $item = new CartItem($itemData['instance'], $itemData['id'], $itemData['quantity']);

                    // setting additional params
                    $mantadoryParams = array('instance', 'id', 'quantity', 'price', 'originPrice');
                    foreach ($itemData as $key => $value) {
                        if (!in_array($key, $mantadoryParams)) {
                            $item->$key = $value;
                        }
                    }
                    $this->items[] = $item;

                    $this->recountOriginTotalPrice();
                    $this->recountTotalPrice();
                }
            } catch (Exception $exc) {
                log_message('error', 'Cart_new: ' . $exc->getMessage());
            }
            self::$instance = $this;
        }
    }

    private function __clone() {
        
    }

    /**
     * get storage object
     * @access protected
     * @author DevImageCms
     * @return IDataStorage
     * @copyright (c) 2013, ImageCMS
     */
    protected function getStorage($storage = NULL) {
        if (!$storage) {

            /* @var $ci \MY_Controller */
            $ci = &get_instance();

            /* @var $dxAuth \DX_Auth */
            $dxAuth = $ci->load->library('DX_Auth');
            if ($dxAuth->is_logged_in()) {
                return new \Cart\DBStorage;
            } else {
                return new \Cart\SessionStorage;
            }
        } else {

            switch ($storage) {
                case 'DBStorage':
                    return new \Cart\DBStorage;
                    break;
                case 'SessionStorage':
                    return new \Cart\SessionStorage;
                    break;
            }
        }
    }

    /**
     * set Quantity for product in cart
     * @access public
     * @author DevImageCms
     * @param array $data input params:
     * - (string) instance: SProducts|ShopKit
     * - (int) id: product or kit id
     * @param int $quantity count of products for setting
     * @return array $data params:
     * - (boolean) success: result of setting quantity
     * - (boolean) setquan: 
     * - (string) errors: message of error
     * @copyright (c) 2013, ImageCMS
     */
    public function setQuantity($data, $quantity) {

        foreach ($this->items as $key => $item)
            if ($data['instance'] == $item->instance && $data['id'] == $item->id) {

                if (TRUE == isAviableInStock($data['instance'], $data['id'], $quantity)) {
                    $this->items[$key]->quantity = $quantity;
                    $this->items[$key]->updateOverallPrice();
                    $set = true;
                } else {
                    return array('success' => FALSE, 'errors' => TRUE, 'message' => 'Not enough in stock');
                }
            }

        if ($set) {
            try {
                $this->dataStorage->setData($this->getArrayToStorage($this->items));
                $data = array('success' => true, 'setquan' => true);
            } catch (Exception $exc) {
                $data = array('success' => false, 'errors' => $exc->getMessage());
                log_message('error', 'Cart_new: ' . $exc->getMessage());
            }

            $this->recountOriginTotalPrice();
            $this->recountTotalPrice();
        } else
            $data = array('success' => true, 'setquan' => false);

        return $data;
    }

    /**
     * set Price Item
     * @access public
     * @author DevImageCms
     * @param array $data input params:
     * - (string) instance: SProducts|ShopKit
     * - (int) id: product or kit id
     * @param float $price new price of products for setting
     * @return array params:
     * - (boolean) success: result of setting price
     * - (boolean) setprice: 
     * - (string) errors: message of error
     * @copyright (c) 2013, ImageCMS
     */
    public function setItemPrice($data, $price) {
        foreach ($this->items as $key => $item)
            if ($data['instance'] == $item->instance && $data['id'] == $item->id) {
                $this->items[$key]->price = $price;
                $set = true;
            }

        if ($set) {
            /* try {
              $this->dataStorage->setData($this->getArrayToStorage($this->items));
              $data = array('success' => true, 'setprice' => true);
              } catch (Exception $exc) {
              $data = array('success' => false, 'errors' => $exc->getMessage());
              log_message('error', 'Cart_new: ' . $exc->getMessage());
              } */

            $this->recountOriginTotalPrice();
            $this->recountTotalPrice();
        } else
            $data = array('success' => true, 'setprice' => false);

        return $data;
    }

    /**
     * Add items to Cart
     * @access public
     * @author DevImageCms
     * @param array $data array with params
     * - (string) instance: required - ShopKit|SProducts
     * - (int) id: required - id of kit or variant
     * - (int) quantity: optional - amount
     * @return array status and errors (if there are so)
     * - (boolean) success: TRUE if item was added with no errors
     * - (string) errors: if success is FALSE, then you can get error that was occured from here
     * @copyright (c) 2013, ImageCMS
     */
    public function addItem(array $data) {
        try {
            $returnData = array('success' => TRUE);
            $recount = FALSE;

            $data['quantity'] = $data['quantity'] > 0 ? $data['quantity'] : 1;
            // if product is already in cart, then only +1 to quantity
            foreach ($this->items as $key => $item) {
                if ($data['instance'] == $item->instance && $data['id'] == $item->id) {
                    // first checking quantity in stock
                    $quantity = $this->items[$key]->quantity + $data['quantity'];

                    if (TRUE == isAviableInStock($data['instance'], $data['id'], $quantity)) {
                        $this->items[$key]->quantity = $quantity;
                        $recount = TRUE;
                    } else {
                        return array('success' => TRUE, 'errors' => 'Not enough in stock');
                    }
                }
            }

            if ($recount == FALSE) {
                // for capability with old fron-end cart (must be removed in future)
                switch ($data['instance']) {
                    case "ShopKit":
                        isset($data['id']) ? NULL : $data['id'] = $data['kitId'];
                        break;
                    case "SProducts":
                        isset($data['id']) ? NULL : $data['id'] = $data['variantId'];
                        break;
                    default:
                        throw new \Exception('Uknown instance');
                }
                // checking quantity in stock
                if (TRUE == isAviableInStock($data['instance'], $data['id'], $data['quantity'])) {
                    if (TRUE == isExistsItems($data['instance'], $data['id']))
                        $this->items[] = new CartItem($data['instance'], $data['id'], $data['quantity']);
                    else
                        $returnData = array('success' => FALSE, 'errors' => 'Not item exists');
                } else {
                    $returnData = array('success' => TRUE, 'errors' => 'Not enough in stock');
                }
            }
            $this->dataStorage->setData($this->getArrayToStorage($this->items));
        } catch (Exception $exc) {
            $returnData = array('success' => false, 'errors' => $exc->getMessage());
            log_message('error', 'Cart_new: ' . $exc->getMessage());
        }


        $this->recountOriginTotalPrice();
        $this->recountTotalPrice();

        return $returnData;
    }

    /**
     * remove item from Cart
     * @access public
     * @author DevImageCms
     * @param array $data input params:
     * - (string) instance: SProducts|ShopKit
     * - (int) id: variant id or kit id
     * @return array params:
     * - (boolean) success: result of operation
     * - (boolean) delete: result of delete item
     * - (string) errors: message of error
     * @copyright (c) 2013, ImageCMS
     */
    public function removeItem($data) {
        $unset = false;
        foreach ($this->items as $key => $item) {
            if ($item->model) {
                if ($data['instance'] == $item->instance && $data['id'] == $item->id) {
                    unset($this->items[$key]);
                    $unset = true;
                    break;
                }
            }
        }
        if ($unset) {
            try {
                $this->dataStorage->remove();
                $this->dataStorage->setData($this->getArrayToStorage($this->items));
                $data = array('success' => true, 'delete' => true);
            } catch (Exception $exc) {
                $data = array('success' => false, 'errors' => $exc->getMessage());
                log_message('error', 'Cart_new: ' . $exc->getMessage());
            }
            $this->recountOriginTotalPrice();
            $this->recountTotalPrice();
        } else
            $data = array('success' => true, 'delete' => false);

        return $data;
    }

    /**
     * get Total items cart
     * @access public
     * @author DevImageCms
     * @return int $total total items cart
     * @copyright (c) 2013, ImageCMS
     */
    public function getTotalItems() {
        return $this->totalItems;
    }

    /**
     * remove all items from cart
     * @access public
     * @author DevImageCms
     * @param ---
     * @return array params:
     * - (boolean) success: result of operation
     * - (boolean) delete: result of delete items
     * - (string) errors: message of error
     * @copyright (c) 2013, ImageCMS
     */
    public function removeAll() {
        try {
            $this->dataStorage = $this->getStorage();
            $this->dataStorage->remove();

            if ($this->dataStorage instanceof \Cart\DBStorage) {
                $this->dataStorage = $this->getStorage('SessionStorage');
                if (count($this->dataStorage->getData())) {
                    $this->dataStorage->remove();
                }
            }

            $this->items = array();
            $data = array('success' => true, 'delete' => true);
        } catch (Exception $exc) {
            $data = array('success' => false, 'errors' => $exc->getMessage());
            log_message('error', 'Cart_new: ' . $exc->getMessage());
        }

        $this->recountOriginTotalPrice();
        $this->recountTotalPrice();
        return $data;
    }

    /**
     * set cart price
     * @access public
     * @author DevImageCms
     * @param float $price new cart price
     * @copyright (c) 2013, ImageCMS
     */
    public function setTotalPrice($price) {

        $this->price = $price;
    }

    /**
     * get total price cart
     * @access public
     * @author DevImageCms
     * @return float $price total price cart
     * @copyright (c) 2013, ImageCMS
     */
    public function getTotalPrice() {

        return number_format($this->price, \ShopCore::app()->SSettings->pricePrecision, '.', '');
    }

    /**
     * get total origin price cart
     * @access public
     * @author DevImageCms
     * @return float $origin_price total origin price cart
     * @copyright (c) 2013, ImageCMS
     */
    public function getOriginTotalPrice() {

        return number_format($this->originPrice, \ShopCore::app()->SSettings->pricePrecision, '.', '');
    }

    /**
     * get one cart items return object classes CartItem
     * @access public
     * @author DevImageCms
     * @param array $data input params:
     * - (string) instance: SProducts|ShopKit
     * - (int) id: product or kit id
     * @return array params:
     * - (boolean) success: result of operation
     * - (array) data: cart items
     * @copyright (c) 2013, ImageCMS
     */
    public function getItem($data) {

        foreach ($this->items as $key => $item) {

            if ($data['instance'] == $item->instance && $data['id'] == $item->id) {
                $data = array('success' => true, 'data' => $item);
                return $data;
            }
        }
        $data = array('success' => true, 'data' => false);
        return $data;
    }

    /**
     * get cart items return array object's classes CartItem
     * @access public
     * @author DevImageCms
     * @param string $instance param for chose items
     * @return array params:
     * - (boolean) success: result of operation
     * - (array) data: cart items
     * @copyright (c) 2013, ImageCMS
     */
    public function getItems($instance = null) {
        $arrayItems = array();
        foreach ($this->items as $key => $item) {
            if ($item->model) {
                if (null === $instance)
                    $arrayItems[] = $item;
                else {
                    if ($item->instance == $instance)
                        $arrayItems[] = $item;
                }
            }
        }
        $data = array('success' => true, 'data' => $arrayItems);
        return $data;
    }

    /**
     * recount cart price and total items
     * @access private
     * @return object BaseCart
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function recountTotalPrice() {

        $this->price = 0;
        $this->totalItems = 0;
        if (count($this->items)) {
            foreach ($this->items as $key => $item) {
                if ($item->model) {
                    $this->price += $item->price * $item->quantity;
                    $this->totalItems += $item->quantity;
                }
            }
        }

        return $this;
    }

    /**
     * recount cart origin price
     * @access private
     * @return object BaseCart
     * @author DevImageCms
     * @copyright (c) 2013, ImageCMS
     */
    private function recountOriginTotalPrice() {
        $this->originPrice = 0;

        if (count($this->items)) {
            foreach ($this->items as $key => $item) {
                if ($item->model) {
                    $aux = number_format($item->originPrice, \ShopCore::app()->SSettings->pricePrecision, '.', '');
                    $this->originPrice += $aux * $item->quantity;
                }
            }
        }
        return $this;
    }

    /**
     * get correct array for set to storage
     * @access private
     * @author DevImageCms
     * @return array $items cart items whith key
     * @copyright (c) 2013, ImageCMS
     */
    private function getArrayToStorage() {
        $result = array();
        foreach ($this->items as $key => $item) {
            if ($item->model) {
                $result[$item->getKey()] = $item->toArray();
            }
        }

        return $result;
    }

    /**
     * Add product to cart from GET data.
     * @param string $instance
     * @return bool
     * @access public
     * @depends 4.5.2
     * @author <dev
     * @copyright (c) 2013 ImageMCMS
     */
    public function add($instance = 'SProducts') {
        try {
            if ($instance == 'SProducts') {

                /** Search for product and variant */
                $model = \SProductsQuery::create()->filterByActive(TRUE)->findPk($this->input->get('productId'));

                /** Is model or throw Excaption */
                ($model != FALSE) OR throwException('Wrong input data. Can\'t add to Cart');

                /** Add Product item to cart */
                $data = array(
                    'model' => $model,
                    'variantId' => (int) $this->input->get('variantId'),
                    'quantity' => (int) $this->input->get('quantity'),
                );
                \ShopCore::app()->SCart->add($data);

                /** Register onAddToCart Event type */
                \CMSFactory\Events::create()->registerEvent($model);
            } elseif ($instance == 'ShopKit') {

                /** Search for product and its variant */
                $model = \ShopKitQuery::create()->filterByActive(TRUE)->findPk((int) $_GET['kitId']);

                /** Is model or throw Excaption */
                ($model != FALSE) OR throwException('Wrong input data. Can\'t add to Cart');

                /** Add Product item to cart */
                $data = array(
                    'model' => $model,
                    'quantity' => 1,
                );
                \ShopCore::app()->SCart->add($data);

                /** Register onAddToCart Event type */
                \CMSFactory\Events::create()->registerEvent($model);
            }
            return true;
        } catch (\Exception $e) {
            $this->errorMessages = $e->getMessage();
            return false;
        }
    }

    /**
     * Remove product from cart by ID.
     * @param int $id
     * @return bool
     * @depends 4.5.2
     * @access public
     * @author <dev
     * @copyright (c) 2013 ImageMCMS
     */
    public function delete($id) {
        try {
            ($this->security->xss_clean($id)) OR throwException('Can\'t remove item from Cart. Incorrect input value');
            \ShopCore::app()->SCart->removeOne($id);
            return TRUE;
        } catch (\Exception $exc) {
            $this->errorMessages = $exc->getMessage();
            return FALSE;
        }
    }

}
