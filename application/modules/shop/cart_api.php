<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * CartApi Controller
 *
 * @uses ShopController
 * @uses \Cart\BaseCart
 * @package Shop
 * @version 1,1
 * @copyright 2013 ImageCMS
 * @author <dev
 */
class Cart_api extends \Cart\BaseCart {

    public function __construct() {
        parent::__construct();
//        ($this->input->is_ajax_request()) OR $this->core->error_404();
    }

    /**
     * @access public
     * @copyright 2013 ImageCMS
     * @author <dev
     */
    public function index() {
        $this->core->error_404();
    }

    /**
     * Add product to cart from GET data.
     * @param string $instance
     * @access public
     * @return JSON
     * @author <dev
     * @copyright (c) 2013 ImageMCMS
     */
    public function add($instance = 'SProducts') {
        if (TRUE === parent::add($instance)) {
            $response = array('success' => true, 'errors' => false);
        } else {
            $response = array('success' => false, 'errors' => true, 'message' => $this->errorMessages);
        }
        return json_encode($response);
    }

    /**
     * Remove product from cart by ID.
     * @param int $id
     * @return bool
     * @access public
     * @author <dev
     * @copyright (c) 2013 ImageMCMS
     */
    public function delete($id) {
        if (parent::delete($id)) {
            $response = array('success' => true, 'errors' => false);
        } else {
            $response = array('success' => false, 'errors' => true, 'message' => $this->errorMessages);
        }
        return json_encode($response);
    }

    /**
     * Recount cart items
     * @author <dev
     * @copyright (c) 2013 ImageMCMS
     * @return JSON
     */
    public function recount() {
        try {
            ($this->input->post('recount') == 1) OR throwException('API, You are drunk, go home!');
            $response = array('success' => true, 'errors' => false);

            /** Recount items */
            $item = ShopCore::app()->SCart->apiRecount();
            if ($item)
                $response['count'] = $item['quantity'];

            /** Return result as JSON */
            return json_encode($response);
        } catch (\Exception $exc) {
            $this->errorMessages = $exc->getMessage();
            $response = array('success' => false, 'errors' => true, 'message' => $this->errorMessages);
            return json_encode($response);
        }
    }

    /**
     * Sync cart data with front
     * @return JSON
     * @access public
     * @author <dev
     * @copyright (c) 2013 ImageMCMS
     */
    public function sync() {
        $response = array();

        if (count(\Currency\Currency::create()->getCurrencies()) > 1 AND \Currency\Currency::create()->default)
            $currentCurrency = SCurrenciesQuery::create()->filterById(\Currency\Currency::create()->default->getId(), Criteria::NOT_EQUAL)->findOne()->getId();
        \Currency\Currency::create()->initCurrentCurrency(null);
        \Currency\Currency::create()->initAdditionalCurrency($currentCurrency);
        $nextCurrency = SCurrenciesQuery::create()->filterById((int) $currentCurrency)->findOne();
        $CSID = $nextCurrency->Id;

        /** Load products from cart */
        $items = ShopCore::app()->SCart->loadProducts();
        foreach ($items as $item) {

            if ($item['instance'] == 'SProducts') {
                $var = SProductVariantsQuery::create()->findPk($item['variantId']);
                if ($var) {
                    $var_photo = preg_match('/nophoto/', $var->getSmallPhoto()) > 0 ? $item['model']->firstVariant->getSmallPhoto() : $var->getSmallPhoto();
                    $var_num = $var->getNumber();
                    $var_stock = $var->getStock();
                }
                $discount = 0;
                $item['model']->getProductVariants();
                if ($item['model']->hasDiscounts())
                    $discount = $item['model']->firstVariant->getVirtual('numDiscount') / $item['model']->firstVariant->toCurrency('OrigPrice') * 100;

                $response['cartItem_' . $item['productId'] . '_' . $item['variantId']] = array(
                    'id' => $item['productId'],
                    'vId' => $item['variantId'],
                    'price' => $var->toCurrency(),
                    'addprice' => $var->toCurrency('Price', $CSID),
                    'origprice' => $var->toCurrency('OrigPrice'),
                    'name' => $item['model']->getName(),
                    'vname' => $item['variantName'],
                    'count' => $item['quantity'],
                    'maxcount' => $var_stock,
                    'number' => $var_num,
                    'url' => shop_url('product/' . $item['model']->getUrl()),
                    'img' => $var_photo,
                    'prodstatus' => promoLabelBtn($item['model']->getAction(), $item['model']->getHot(), $item['model']->getHit(), $discount)
                );
            } else {
                $response['cartItem_' . implode(',',$item['model']->getProductIdCart()) . '_' . $item['model']->getMainProduct()->firstVariant->getId()] = array(
                    'count' => $item['quantity'],
                    'kit' => true,
                    'price' => $item['model']->getTotalPrice(),
                    'prices' => json_encode($item['model']->getPriceCart()),
                    'addprice' => $item['model']->getTotalPrice($CSID),
                    'addprices' => json_encode($item['model']->getPriceCart($CSID)),
                    'origprice' => $item['model']->getTotalPriceOld(),
                    'origprices' => json_encode($item['model']->getOrigPriceCart()),
                    'id' => implode(',',$item['model']->getProductIdCart()),
                    'name' => json_encode($item['model']->getNamesCart()),
                    'kitId' => $item['model']->getId(),
                    'vId' => $item['model']->getMainProduct()->firstVariant->getId(),
                    'url' => json_encode($item['model']->getUrls()),
                    'img' => json_encode($item['model']->getImgs()),
                    'maxcount' => $item['model']->getSProducts()->firstVariant->getStock(),
                    'prodstatus' => json_encode($item['model']->getKitStatus())
                );
            }
        }

        return json_encode(array('success' => true, 'errors' => false, 'data' => array('items' => $response)));
    }

    public function get_kit_discount() {
        $items = \ShopCore::app()->SCart->loadProducts();
        $disc = 0;
        foreach ($items as $item) {
            if ($item['instance'] == 'ShopKit') {
                $disc += ($item['model']->getTotalPriceOld() - $item['model']->getTotalPrice()) * $item['quantity'];
            }
        }
        //if ()
        
        return 0;
    }

    /**
     * Clear Cart data
     * @return JSON
     * @access public
     * @author <dev
     * @copyright (c) 2013 ImageMCMS
     */
    public function clear() {
        ShopCore::app()->SCart->removeAll();
        return json_encode(array('success' => true, 'errors' => false));
    }

    /**
     * Get Gift Certificate
     * @access public
     * @author <dev
     * @copyright (c) 2013 ImageMCMS
     * @return JSON
     */
    public function getGiftCert() {
        try {
            /** Is correct request? */
            (($this->input->get('giftcert')) && ($this->input->get('giftcert') != NULL)) OR throwException('dasdas');

            $certUsage = $this->db->where('gift_cert_key', $this->input->get('giftcert'))->post('shop_orders')->num_rows();

            if ($certUsage == 0) {
                $select_cert = $this->db->where('key =', $this->input->get('giftcert'))
                        ->where('active =', 1)
                        ->get('shop_gifts', 1)
                        ->row_array();
            }
            if ($this->input->post('checkCert') == 1) {
                $response = array('success' => true, 'errors' => false);
                if ($select_cert != null AND $certUsage == 0)
                    $response['cert_price'] = $select_cert['price'];
                else {
                    $response['cert_price'] = 0;
                    $response['errors'][] = 'Not valid certificate';
                }
                return json_encode($response);
            }
        } catch (\Exception $exc) {
            $response = array(
                'success' => FALSE,
                'errors' => TRUE,
                'message' => $exc->getMessage()
            );
            return json_encode($data);
        }
    }

    /**
     * Get Payment Methods by ID
     * @param int $deliveryId
     * @return JSON
     * @author <dev
     * @copyright (c) 2013 ImageCMS
     */
    public function getPaymentsMethods($deliveryId) {
        $paymentMethods = ShopDeliveryMethodsSystemsQuery::create()->filterByDeliveryMethodId($deliveryId)->find();
        foreach ($paymentMethods as $paymentMethod) {
            $paymentMethodsId[] = $paymentMethod->getPaymentMethodId();
        }
        $paymentMethod = SPaymentMethodsQuery::create()->filterByActive(true)->where('SPaymentMethods.Id IN ?', $paymentMethodsId)->orderByPosition()->find();

        $jsonData = array();
        foreach ($paymentMethod->getData() as $pm) {
            $jsonData[] = array(
                'id' => $pm->getId(),
                'name' => $pm->getName(),
                'description' => $pm->getDescription()
            );
        }

        echo json_encode($jsonData);
    }

}

/* End of file cart_api.php */