<?php 

 use Base\SOrders as BaseSOrders;
 
 use Propel\Runtime\ActiveQuery\Criteria;
 use Propel\Runtime\Connection\ConnectionWrapper;

/**
 * Skeleton subclass for representing a row from the 'shop_orders' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SOrders extends BaseSOrders {

    public $entityName = 'order';
    private $_kitsProducts = null;
    private $changedPaidStatus = false;

// 	public function __construct()
// 	{
// 		parent::__construct();
// 		$this->collectCustomData($this->entityName, $this->getId());
// 	}

    public static function getStatusName($filterField = '', $filterValue = 0) {
        $orderStatus = SOrderStatusesQuery::create()->orderByPosition(Criteria::ASC)->joinWithI18n(MY_Controller::getCurrentLocale());
        if ($filterField != '' && $filterValue !== 0) {
            $orderStatus = $orderStatus->filterBy($filterField, $filterValue);
        }
        $orderStatus = $orderStatus->findOne();
        return $orderStatus->getName();
    }

    public static function getStatuses() {
        foreach (SOrderStatusesQuery::create()->joinWithI18n(MY_Controller::getCurrentLocale())->orderByPosition(Criteria::ASC)->find() as $orderStatus) {
            $orderStatuses[0][$orderStatus->getId()] = $orderStatus;
            $orderStatuses[1][$orderStatus->getId()] = $orderStatus->getName();
        }
        return $orderStatuses;
    }

    public function attributeLabels() {
        return array(
            'Key' => ShopCore::t('Ключ'),
            'DeliveryMethod' => ShopCore::t('Метод доставки'),
            'DeliveryPrice' => ShopCore::t('Цена доставки'),
            'PaymentMethod' => ShopCore::t('Метод оплаты'),
            'Status' => ShopCore::t('Статус'),
            'StatusComment' => ShopCore::t('Комментарий к изменению статуса'),
            'Paid' => ShopCore::t('Оплачен'),
            'UserFullName' => ShopCore::t('Полное Имя'),
            'UserEmail' => ShopCore::t('Почта'),
            'UserPhone' => ShopCore::t('Номер телефона'),
            'UserDeliverTo' => ShopCore::t('Адрес доставки'),
            'UserComment' => ShopCore::t('Комментарий'),
            'DateCreated' => ShopCore::t('Дата создания'),
            'DateUpdated' => ShopCore::t('Дата обновления'),
            'UserIp' => ShopCore::t('Ip'),
        );
    }

    /**
     * Get total price for order
     *
     * @return int
     */
    public function getTotalPrice($CS = null) {
//        $totalPrice = 0;
//
//        foreach ($this->getSOrderProductss() as $p) {
//            $totalPrice = $totalPrice + $p->getPrice() * $p->getQuantity();
//        }
//
//        return \Currency\Currency::create()->convert($totalPrice);

        return \Currency\Currency::create()->convert(parent::getTotalPrice(), $CS);
    }

    public function getTotalPriceWithDelivery() {
        return \Currency\Currency::create()->convert(($this->getTotalPrice() + $this->getDeliveryPrice()));
    }

    public function getTotalPriceWithGift() {
        return ( $this->getTotalPriceWithDelivery() - $this->getGiftCertPrice()) >= 0 ? $this->getTotalPriceWithDelivery() - $this->getGiftCertPrice() : 0;
    }

    public function updateTotalPrice() {
        $totalPrice = 0;

        foreach ($this->getSOrderProductss() as $p) {
            $totalPrice = $totalPrice + $p->getPrice() * $p->getQuantity();
        }
        $this->setTotalPrice($totalPrice);
    }
    
    public function updateOriginPrice() {
        $originPrice = 0;

        foreach ($this->getSOrderProductss() as $p) {
            $originPrice = $originPrice + $p->getOriginPrice() * $p->getQuantity();
        }
        $this->setOriginPrice($originPrice);
    }

    public function incrementTotalPrice($price, $inc) {

        $this->setTotalPrice($price + $inc);
        $this->save();
    }

    public function getOrderProducts() {
        $tempForKits = array();
        $this->_kitsProducts = [];
        $criteria = SOrderProductsQuery::create()->useSProductsQuery()->orderByViews(Criteria::ASC)->endUse();
        $model = $this->getSOrderProductss($criteria);
        
        foreach ($model as $key => $value) {
            $value->setVirtualColumn('productTotalPrice', \Currency\Currency::create()->convert($value->quantity * $value->price));
            
            if (!$value->getKitId() && $this->getDiscountInfo() == 'user'){
                $value->setPrice($value->getOriginPrice());       
            }

            if ($value->getKitId()) {
                if ($value->getIsMain()) {                        
                    $value->setVirtualColumn('Kit', ShopKitQuery::create()->findPk($value->getKitId()));
                    $this->_kitsProducts[] = $value;
                }
                $model->remove($key);
            }
        }
        return $model;
    }

    public function getOrderKits() {
        if (!is_array($this->_kitsProducts))
            $this->getOrderProducts();
        return $this->_kitsProducts;
    }

    public function updateDeliveryPrice() {
        $delivery = $this->getDeliveryMethod();
        if (!empty($delivery)) {
            $totalPrice = (int) $this->getTotalPrice();
            $freeFrom = (int) $this->getSDeliveryMethods()->getFreeFrom();
            $deliveryPrice = $totalPrice > $freeFrom ? 0 : $this->getSDeliveryMethods()->getPrice();
            $this->setDeliveryPrice($deliveryPrice);
        }
    }

    public function postSave() {
        $this->updateTotalPrice();
        $this->hasCustomData = false;
        $this->customFields = false;
        if ($this->hasCustomData === false)
            $this->collectCustomData($this->entityName, $this->getId());
        $this->saveCustomData();

        //saving custom data
        //TODO: need recode to use $this->saveCustomData()
        //       ShopCore::app()->CustomFieldsDataQuery->saveCustomFieldsData($this->getId(), $this->entityName);
//        if (count($_POST['custom_field']))
//            $this->saveCustomData();

        parent::postSave();
    }

    public function getpaymentMethodName() {
        if ($this->payment_method !== null) {
            $result = SPaymentMethodsQuery::create()->findPk($this->payment_method, $con);
        }
        return $result->name;
    }

    /* if recount option is swiched on
     * needs $_SESSION['recount'] variable to be set in controller
     * $_SESSION['recount'] is set when paid option is switched on in orders.php->edit method
     */

    public function preUpdate(ConnectionWrapper $con = null) {
        $paid = (bool) \CI::$APP->db
                        ->select(array('paid'))
                        ->get_where('shop_orders', array('id' => $this->getId()))
                        ->row()->paid;
        $this->changedPaidStatus = $paid != $this->getPaid();
        return parent::preUpdate($con);
    }

    public function postUpdate(ConnectionWrapper $con = null) {
        if (ShopCore::app()->SSettings->ordersRecountGoods == 1 && $this->changedPaidStatus) {
            $productsInCart = SOrderProductsQuery::create()->filterByOrderId($this->getId())->find();
            if (count($productsInCart) > 0) {
                foreach ($productsInCart as $productInCart) {
                    $variantToUpdate = SProductVariantsQuery::create()->findPk($productInCart->getVariantId());
                    if ($this->getPaid()) {
                        if ($variantToUpdate->getStock() <= $productInCart->getQuantity()) {
                            $stock = 0;
                            $variantToUpdate->setStock($stock);
                        } else {
                            $variantToUpdate->setStock($variantToUpdate->getStock() - $productInCart->getQuantity());
                        }
                    } else {
                        $variantToUpdate->setStock($variantToUpdate->getStock() + $productInCart->getQuantity());
                    }
                    $variantToUpdate->save();
                }
            }
        }
        return parent::postUpdate($con);
    }

//    public function postSave()
//    {
//        if (is_numeric($this->getId()) )
//            ShopCore::app()->CustomFieldsDataQuery->saveCustomFieldsData($this->getId(), 'order');
//        parent::preSave();
//        return $this;
//    }
}