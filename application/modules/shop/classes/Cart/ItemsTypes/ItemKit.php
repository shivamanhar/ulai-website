<?php

namespace Cart\ItemsTypes;

use \Cart\CartItem as CartItem;

/**
 *
 * @property \ShopKit $model
 * @author
 */
class ItemKit extends IItemType
{

    /**
     * Products of kit (first variants of products)
     * @var array
     */
    public $items = array();

    /**
     * Holds main variant of id
     * @var int
     */
    public $mainVariantId;

    public function getModel()
    {
        // main kit model
        $this->model = \ShopKitQuery::create()
            ->filterById((int)$this->cartItem->id)
            ->findOne();
        $this->getInnerItems();
    }

    public function getName()
    {
        foreach ($this->items as $item)
            return $item->getName();
    }


    /**
     * Get Kit stock value
     * @return int
     */
    public function getStock()
    {
        $stockNumber = 0;
        if ($this->items) {
            foreach ($this->items as $item) {
                $itemStock = $item->getSProducts()->firstVariant->getStock();
                if (!$stockNumber) {
                    $stockNumber = $itemStock;
                } else {
                    $stockNumber = $stockNumber > $itemStock ? $itemStock : $stockNumber;
                }
            }
        }
        return $stockNumber;
    }

    /**
     * Filling $this->items array with first variants of products
     */
    protected function getInnerItems()
    {
        $ci = &get_instance();
        // getting products of kit
        $result = $ci->db
            ->where('kit_id', $this->cartItem->id)
            ->get('shop_kit_product')
            ->result_array();

        // getting all product ids
        if ($this->model) {
            $mainProductId = $this->model->getProductId();
            $productIds = array($mainProductId);
            // default discount for main product = 0
            $discounts = array($mainProductId => 0);
            foreach ($result as $kitData) {
                $productIds[] = (int)$kitData['product_id'];
                $discounts[(int)$kitData['product_id']] = $kitData['discount'];
            }

            $order = array_flip($productIds);
            // getting first variants ids of products
            $variantIds = $ci->db
                ->select('id, product_id, price')
                ->where_in('product_id', $productIds)
                ->order_by('position', 'DESC')
                ->group_by('id')
                ->get('shop_product_variants')
                ->result_array();

            // creating cart items

            foreach ($variantIds as $variantData) {
                $price = $variantData['price'] * ((100 - $discounts[$variantData['product_id']]) / 100);
                $this->items[$order[$variantData['product_id']]] = new CartItem(CartItem::TYPE_PRODUCT, $variantData['id'], 1, $price);
            }

            ksort($this->items);
        }
    }

    /**
     * Returns price of products kit (including discount of additional products)
     * @return float
     */
    public function getOriginPrice()
    {

        foreach ($this->items as $item)
            $origPrice += $item->originPrice;

        return $origPrice;
    }

    public function getPrice()
    {
        foreach ($this->items as $item)
            $price += $item->price;

        return $price;
    }

    public function getItem($variantId)
    {
        foreach ($this->items as $innerItem) {
            if ($innerItem->id == $variantId) {
                return $innerItem;
            }
        }
        return FALSE;
    }

    public function getAllItems()
    {
        return $this->items;
    }

    protected function addDeprecatedFields()
    {
        $this->cartItem->kitId = $this->cartItem->id;
    }

}

?>
