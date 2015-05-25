<?php

namespace Cart\ItemsTypes;

/**
 * Each type of cart item must extend abstract class IItemType
 * and got model operations in most
 */
abstract class IItemType {

    /**
     * Reference to parent
     * @var CartItem 
     */
    protected $cartItem;

    /**
     * Model of concrete type
     * @var type 
     */
    public $model;

    public function __construct($cartItem) {
        $this->cartItem = $cartItem;
        $this->getModel();
        $this->addDeprecatedFields(); // shoud be removed in future
    }

    /**
     * @return float origin price of item (may be calculated)
     */
    abstract public function getOriginPrice();

    /**
     * Sets models in current object
     * @return void 
     */
    abstract protected function getModel();

    /**
     * Adds additionals fields to object for compatibility with old front-end cart
     */
    abstract protected function addDeprecatedFields();
}

