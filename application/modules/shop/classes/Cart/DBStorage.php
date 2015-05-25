<?php

namespace Cart;

/**
 * Class for work with Cart, saved in database.
 * @copyright 2013 Siteimage
 * @author <dev 
 */
class DBStorage extends \Cart\IDataStorage {

    private $cart;

    /**
     * Prepare cart data
     * @return boolean|array
     */
    private function prepareCartData() {
        /** Get user cart data if is logged in * */
        if (\ShopCore::$ci->dx_auth->is_logged_in() === true) {
            $sUserData = \SUserProfileQuery::create()->filterById(\ShopCore::$ci->dx_auth->get_user_id())->findOne();
            if ($sUserData != null)
                $this->cart = unserialize($sUserData->getCartData());
        }

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
        };
    }

    /**
     * Save cart data to storage
     * @param  array $data
     * @return boolean
     */
    public function setData($data = null) {

        if ($data) {
            /** Serialize and check result * */
            if ((!$serializeData = serialize($data))) {
                throw new \Exception("Error serialize data");
            }
        } else {
            $serializeData = '';
        }
        
        /** Set user cart data if logged in * */
        if (\ShopCore::$ci->dx_auth->is_logged_in() === true) {
            $sUserData = \SUserProfileQuery::create()->filterById(\ShopCore::$ci->dx_auth->get_user_id())->findOne();
            if (!$sUserData)
                throw new \Exception("Error getting user data");

            $sUserData->setCartData($serializeData);
            return (boolean) $sUserData->save();
        }
        throw new \Exception("User is not logged in");
    }

    /**
     * Remove items from cart storage by params
     * @param int $type
     * @param int $id
     * @return boolean
     */
    public function remove($type = null, $id = null) {

        /** Prepare cart data * */
        $data = $this->prepareCartData();

        /** Convert type int to string instance* */
        if (is_int($type) == TRUE)
            $type = \Cart\CartItem::convertType($type);

        $data = parent::removeByParams($data, $type, $id);

        /** Save result * */
        return $this->setData($data);
    }

}

