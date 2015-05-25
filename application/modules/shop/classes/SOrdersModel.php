<?php

use Propel\Runtime\ActiveQuery\Criteria;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SOrdersModel {

    public function __construct() {
        $this->ci = &get_instance();
        $this->db = &$this->ci->db;
        $this->locale = MY_Controller::getCurrentLocale();
    }

    public function getOrdersByID($userID, $criteria = Criteria::DESC) {
        return SOrdersQuery::create()
                        ->orderByDateCreated($criteria)
                        ->joinSOrderStatuses()
                        ->filterByUserId($userID)
                        ->find();
    }

    public function getOrdersByKey($orderSecretKey) {
        return SOrdersQuery::create()
                        ->filterByKey($orderSecretKey)
                        ->findOne();
    }

}
