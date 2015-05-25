<?php

namespace Cart;

/**
 * Class for work with Cart, saved in session.
 * @copyright 2013 Siteimage
 * @author <dev 
 */
class SessionStorage extends \Cart\IDataStorage {

    private $sessKey = 'ShopCartData'; // Session key to store cart items list.
    private $cart;

    /**
     * Prepare cart data
     * @return boolean|array
     */
    private function prepareCartData() {
        /** Get user cart data if is logged in * */
        $this->cart = \ShopCore::$ci->session->userdata($this->sessKey);

        if ($this->cart == null) {
            return array();
        } else {
            return $this->cart;
        }
    }

    /**
     * Get cart from storage by params
     * @param int $type
     * @param int $id
     * @return boolean|array
     */
    public function getData($type = null, $id = null) {

        /** Prepare cart data * */
        $data = $this->prepareCartData();

        /** Convert type int to string instance* */
        if (is_int($type) == TRUE)
            $type = \Cart\CartItem::convertType($type);

        /** Filter by params * */
        $result = parent::filterByParams($data, $type, $id);

        /** Return result * */
        if ($result) {
            return $result;
        } else {
            return array();
        }
    }

    /**
     * Save cart data to storage
     * @param  $data
     * @return boolean
     */
    public function setData($data = null) {
        \ShopCore::$ci->session->set_userdata($this->sessKey, $data);
        return TRUE;
    }

    /**
     * Remove items from cart storage by params
     * @param int $type
     * @param int $id
     * @return boolean
     */
    public function remove($type, $id) {
        /** Prepare cart data * */
        $data = $this->prepareCartData();

        /** Convert type int to string instance* */
        if (is_int($type) == TRUE)
            $type = \Cart\CartItem::convertType($type);

        /** Remove items by params * */
        $data = parent::removeByParams($data, $type, $id);

        /** Save result * */
        return $this->setData($data);
    }

    /**
     * Save data from seesion to storage
     * @return type
     */
    public function exportToDB() {
        /** Get data from session * */
        $sessionData = $this->getData();

        /** Save data to database * */
        $dbStorage = new DBStorage();
        return $dbStorage->setData($sessionData);
    }

}
