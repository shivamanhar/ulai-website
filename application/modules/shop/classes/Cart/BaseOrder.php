<?php

namespace Cart;

/**
 * 
 *
 * @author
 */
class BaseOrder extends \ShopController {

    /**
     * 
     * @param string $typeId 
     * @param int $id
     * @param int $quantity
     * @param float $price
     */
    public function __construct() {
        parent::__construct();
    }

    /** Create new order */
    public static function create($data = null, &$products = null) {

        if ($data == null) {
            throw new \Exeption("Can't create empty order");
        }

        $order = new \SOrders;

        $order->setUserId($data['userId']);
        $order->setKey(self::createCode());
        $order->setDeliveryMethod($data['deliveryMethodId']);
        $order->setDeliveryPrice($data['deliveryPrice']);
        $order->setPaymentMethod($data['paymentMethodId']);
        $order->setStatus(1);
        $order->setUserFullName($data['userFullName']);
        $order->setUserSurname($data['userSurname']);
        $order->setUserEmail($data['userEmail']);
        $order->setUserPhone($data['userPhone']);
        $order->setUserDeliverTo($data['userDeliverTo']);
        $order->setUserComment($data['userCommentText']);
        $order->setDateCreated(time());
        $order->setDateUpdated(time());
        $order->setUserIp($data['userIp']);

        /** Get cart items * */
        $cart = \Cart\BaseCart::getInstance();


        $items = $cart->getItems();




        /** Add products * */
        foreach ($items['data'] as $cartItem) {

            $product = array(
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
            );

            if ($cartItem->instance == 'SProducts') {

                $model = $cartItem->getSProducts();

                $model->setAddedToCartCount($model->getAddedToCartCount() + $cartItem->quantity);
                $model->save();

                $orderedItem = new \SOrderProducts;

                //$product['variant_name'] = $cartItem->getName();

                $orderedItem->fromArray(array(
                    'ProductId' => $model->getId(),
                    'VariantId' => $cartItem->getId(),
                    'ProductName' => $model->getName(),
                    'VariantName' => $cartItem->getName(),
                    'Quantity' => $cartItem->quantity));

                $orderedItem->fromArray(array('Price' => $cartItem->price, 'OriginPrice' => $cartItem->originPrice));

                $order->addSOrderProducts($orderedItem);
            } elseif ($cartItem->instance == 'ShopKit') {

                $model = $cartItem;

                /** Adding main product of kit to the order * */
                $mp = $model->getMainProduct();
                $mp->setAddedToCartCount($mp->getAddedToCartCount() + $cartItem->quantity);
                $mp->save();

                $mpV = $mp->getFirstVariant('kit');

                $product['variant_name'] = $mp->getName();

                $orderedItem = new \SOrderProducts;
                $orderedItem->fromArray(array(
                    'KitId' => $model->getId(),
                    'ProductId' => $mp->getId(),
                    'VariantId' => $mpV->getId(),
                    'ProductName' => $mp->getName(),
                    'VariantName' => $mpV->getName(),
                    'Quantity' => $cartItem->quantity,
                    'IsMain' => TRUE,));

                $orderedItem->fromArray(array('Price' => $mpV->getPrice(), 'OriginPrice' => $mpV->getPrice()));

                $order->addSOrderProducts($orderedItem);

                /** Adding atached products of kit to the order * */
                foreach ($model->getShopKitProducts() as $shopKitProduct) {
                    $ap = $shopKitProduct->getSProducts();
                    $ap->setAddedToCartCount($ap->getAddedToCartCount() + $cartItem->quantity);
                    $ap->save();

                    $apV = $ap->getKitFirstVariant($shopKitProduct);

                    $orderedItem = new \SOrderProducts;
                    $orderedItem->fromArray(array(
                        'KitId' => $model->getId(),
                        'ProductId' => $ap->getId(),
                        'VariantId' => $apV->getId(),
                        'ProductName' => $ap->getName(),
                        'VariantName' => $apV->getName(),
                        'Quantity' => $cartItem->quantity,
                        'IsMain' => FALSE,
                            )
                    );

                    $orderedItem->fromArray(array('Price' => $apV->getPrice(), 'OriginPrice' => $apV->getPrice() + $apV->getvirtual('economy')));

                    $order->addSOrderProducts($orderedItem);
                }
            }

            $products[] = $product;
        }

        $order->setTotalPrice($cart->getTotalPrice());
        $order->setOriginPrice($cart->getOriginTotalPrice());
        if ($cart->gift_info) {
            $order->setGiftCertKey($cart->gift_info);
            $order->setGiftCertPrice($cart->gift_value);
        }
        if ($cart->getOriginTotalPrice() > $cart->getTotalPrice()) {
            $discount = $cart->getOriginTotalPrice() - $cart->getTotalPrice();
            if (!empty($cart->gift_value)) {
                $discount -= $cart->gift_value;
            }
            $order->setDiscount($discount > 0 ? $discount : null);
            $order->setDiscountInfo($cart->discount_type);
        }
       
        /** Try to save order * */
        if ($order->save()) {
            /** Clear cart and return order* */
            $cart->removeAll();
            return $order;
        } else {
            throw new \Exeption('Error creating new order');
        }
    }

    /*     * *********** Move to CART           * */

    /**
     * Get delivery methods
     * @return type
     */
    public function getDeliveryMethods($id = null) {
        if (!$id)
            $deliveryMethods = \SDeliveryMethodsQuery::create()
                    ->joinWithI18n(\MY_Controller::getCurrentLocale())
                    ->enabled()
                    ->orderBy('SDeliveryMethods.Position')
                    ->find();
        else
            $deliveryMethods = \SDeliveryMethodsQuery::create()
                    ->joinWithI18n(\MY_Controller::getCurrentLocale())
                    ->enabled()
                    ->filterById($id)
                    ->findOne();

        if ($deliveryMethods) {
            return $deliveryMethods;
        } else {
            return array();
        }
    }

    /**
     * Create random code.
     *
     * @param int $charsCount
     * @param int $digitsCount
     * @static
     * @access public
     * @return string
     */
    public static function createCode($charsCount = 3, $digitsCount = 7) {
        $chars = array('q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm');

        if ($charsCount > sizeof($chars))
            $charsCount = sizeof($chars);

        $result = array();
        if ($charsCount > 0) {
            $randCharsKeys = array_rand($chars, $charsCount);

            foreach ($randCharsKeys as $key => $val)
                array_push($result, $chars[$val]);
        }

        for ($i = 0; $i < $digitsCount; $i++)
            array_push($result, rand(0, 9));

        shuffle($result);

        $result = implode('', $result);

        if (sizeof(\SOrdersQuery::create()->filterByKey($result)->select(array('Key'))->limit(1)->find()) > 0)
            self::createCode($charsCount, $digitsCount);

        return $result;
    }

    /**
     * Save order history
     * @param type $id
     * @param type $userId
     * @param type $comment
     */
    public function saveOrdersHistory($orderId, $userId, $comment = null) {
        /** Save to order statuses history table * */
        $orderStatus = new \SOrderStatusHistory;
        $orderStatus->setOrderId($orderId);
        $orderStatus->setStatusId(1);
        $orderStatus->setUserId($userId);
        $orderStatus->setDateCreated(time());
        $orderStatus->setComment($comment);

        if ($orderStatus->save()) {
            return $orderStatus;
        } else {
            throw new \Exeption('Error saving order history');
        }
    }

    /**
     * Creates the table with order info for cmsemail 'make_order' template
     * @param array $productsInfo
     * @return string html table
     */
    public function createProducsInfoTable($cartItems = array(), $discount = 0) {
        if ($cartItems['success']) {
            $cartItems = $cartItems['data'];

            /** Getting the site's default currency symbol * */
            $defaultCurrency = \Currency\Currency::create()->getSymbol();

            $tdStyle = " style='border: 1px solid #e5e5e5; padding: 5px' ";

            /** Begining creating the table * */
            $productsForEmail = "<table cellspacing='0' style='min-width: 400px; border: 1px solid #eaeaea;'>" .
                    "<thead>" .
                    "   <th{$tdStyle}>Продукт</th>" .
                    "   <th{$tdStyle}>Вариант</th>" .
                    "   <th{$tdStyle}>Количество</th>" .
                    "   <th{$tdStyle}>Цена</th>" .
                    "   <th{$tdStyle}>Cумма</th>" .
                    "</thead>" .
                    "<tbody>";

            $total = 0;
            // adding product rows
            foreach ($cartItems as $item) {
                $curTotal = $item->price * $item->quantity;
                $total += $curTotal;
                $productsForEmail .= "<tr>" .
                        "<td{$tdStyle}>{$item->getSProducts()->getName()}</td>" .
                        "<td{$tdStyle}>{$item->getName()}</td>" .
                        "<td{$tdStyle}>{$item->quantity}</td>" .
                        "<td{$tdStyle}>{$item->price} {$defaultCurrency}</td>" .
                        "<td{$tdStyle}>{$curTotal} {$defaultCurrency}</td>" .
                        "</tr>";
            }

            // if there is a discount
            if ($discount) {
                $total -= $discount;
                $productsForEmail .= "<tr><td colspan='4'{$tdStyle}>Сумма скидки</td><td{$tdStyle}>{$discount} {$defaultCurrency}</td></tr>";
            }

            // total row
            $productsForEmail .= "<tr><td colspan='4'{$tdStyle}>Общая сумма</td><td{$tdStyle}>{$total} {$defaultCurrency}</td></tr>";
            $productsForEmail .= "</tbody></table>";
            return $productsForEmail;
        } else {
            return FALSE;
        }
    }

}
