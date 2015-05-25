<?php

/**
 * Class Orders_model for mod_stats module
 * @uses \CI_Model
 * @author DevImageCms
 * @copyright (c) 2014, ImageCMS
 * @property CI_DB_active_record $db
 * @package ImageCMSModule
 */
class Orders_model extends CI_Model {


    /**
     * Helper function to create all conditions
     * @param array $params
     * @return array(paid condition, between condition)
     */
    protected function prepareConditions(array $params) {

        $paidCondition = "";
        if (isset($params['paid'])) {
            switch ($params['paid']) {
                case 1:
                    $paidCondition = "AND `paid` = 1";
                    break;
                case 0:
                    $paidCondition = "AND (`paid` <> 1 OR `paid` IS NULL)";
                    break;
            }
        }

        $betweenCondition = "";
        if (isset($params['dateFrom']) || isset($params['dateTo'])) {
            $dateFrom = isset($params['dateFrom']) ? $params['dateFrom'] : '2005-01-01';
            $dateTo = isset($params['dateTo']) ? $params['dateTo'] : date('Y-m-d');
            $betweenCondition = "AND FROM_UNIXTIME(`date_created`) BETWEEN '{$dateFrom} 00:00:00' AND '{$dateTo} 23:59:59'";
        }

        return array($paidCondition, $betweenCondition);
    }

    /**
     * Getting information about orders
     * @param array $params
     *  - interval
     *  - from (date)
     *  - to (date)
     *  - paid
     * @return boolean|array
     * arrays with fields:
     *  - orders_count
     *  - price_sum
     *  - products_count
     *  - quantity
     *  - delivered
     */
    public function getOrdersInfo(array $params = array()) {
        list($paidCondition, $betweenCondition) = $this->prepareConditions($params);
        
        $interval = isset($params['interval']) ? $params['interval'] : NULL;

        $query = "
            SELECT
                `dtable`.`date_created` as `unix_date`,
                DATE_FORMAT(FROM_UNIXTIME(`dtable`.`date_created`), '" . \mod_stats\classes\DateInterval::getDatePattern($interval) . "') as `date`,
                SUM(`dtable`.`origin_price`) as `price_sum`,
                COUNT(`dtable`.`id`) as `orders_count`,
                SUM(`dtable`.`products_count`) as `products_count`,
                SUM(`dtable`.`quantity`) as `quantity`,
                SUM(`dtable`.`status`) as `delivered`,
                SUM(`paid`) as `paid`
            FROM 
                (SELECT 
                    `shop_orders`.`id`,
                    `shop_orders`.`date_created`,
                    IFNULL(`shop_orders`.`paid`, 0) as `paid`,
                    -- IF(ISNULL(`shop_orders`.`origin_price`), 0, `shop_orders`.`origin_price`) as `origin_price`,
                    SUM(`shop_orders_products`.`price`) as `origin_price`,
                    IF(`shop_orders`.`status` = 2, 1, 0) as `status`,
                    COUNT(`shop_orders_products`.`order_id`) as `products_count`,
                    SUM(`shop_orders_products`.`quantity`) as `quantity`
                 FROM 
                    `shop_orders`
                 LEFT JOIN `shop_orders_products` ON `shop_orders_products`.`order_id` = `shop_orders`.`id`
                 WHERE 1
                     AND FROM_UNIXTIME(`shop_orders`.`date_created`) <= NOW() + INTERVAL 1 DAY 
                 GROUP BY 
                    `shop_orders`.`id`
                 ORDER BY 
                    FROM_UNIXTIME(`shop_orders`.`date_created`)
                ) as dtable
            WHERE 1 
                {$betweenCondition}
                {$paidCondition} 
            GROUP BY `date`
            ORDER BY FROM_UNIXTIME(`date_created`)
        ";

        $result = $this->db->query($query);
        if ($result === FALSE) {
            return FALSE;
        }
        $ordersData = array();
        foreach ($result->result_array() as $row) {
            $ordersData[] = $row;
        }
        return $ordersData;
    }

    /**
     * Information about orders grouped by users
     * @param arra $params standart params
      @return boolean|array
     *  - orders_count
     *  - paid
     *  - price_sum
     *  - products_count
     *  - quantity
     *  - delivered
     *  - orders_ids
     *  - username
     *  - user_id
     * Get users info 
     */
    public function getUsers(array $params_ = array()) {
        $params = array(
            'interval' => 'day',
            'dateFrom' => NULL,
            'dateTo' => NULL,
            'username' => NULL,
            'order_id' => NULL,
        );
        foreach ($params_ as $key => $value) {
            if (key_exists($key, $params)) {
                $params[$key] = $params_[$key];
            }
        }

        $codumns = array(
            'date', 'orders_count', 'paid', 'unpaid', 'delivered', 'price_sum', 'products_count', 'quantity', 'orders_ids', 'username', 'user_id'
        );

        $orderBy = NULL;
        if (isset($_GET['orderMethod']) && isset($_GET['order'])) {
            if (in_array($_GET['orderMethod'], $codumns) && ($_GET['order'] == "ASC" || $_GET['order'] == "DESC")) {
                $orderBy = "ORDER BY `{$_GET['orderMethod']}` {$_GET['order']}";
            }
        }
        $orderBy = is_null($orderBy) ? 'ORDER BY `orders_count` DESC' : $orderBy;

        $otherConditions = "";
        if (!is_null($params['username']) && !empty($params['username'])) {
            $otherConditions .= " AND `username` LIKE '%{$params['username']}%' ";
        }
        if (!is_null($params['order_id']) && !empty($params['order_id'])) {
            $otherConditions .= " AND `order_id` = {$params['order_id']} ";
        }

        $query = "
            SELECT
                DATE_FORMAT(FROM_UNIXTIME(`date_created`), '" . \mod_stats\classes\DateInterval::getDatePattern($params['interval']) . "') as `date`,
                COUNT(`order_id`) as `orders_count`,
                SUM(`paid`) as `paid`,
                COUNT(`order_id`) - SUM(`paid`) as `unpaid`,
                SUM(`status`) as `delivered`,
                SUM(`origin_price`) as `price_sum`,
                SUM(`products_count`) as `products_count`,
                SUM(`quantity`) as `quantity`,
                GROUP_CONCAT(`order_id` SEPARATOR ', ') as `orders_ids`,
                `username`,
                `user_id`
            FROM 
                (SELECT 
                    `shop_orders`.`id` as `order_id`,
                    `shop_orders`.`date_created`,
                    IFNULL(`shop_orders`.`paid`, 0) as `paid`,
                    SUM(`shop_orders_products`.`price`) as `origin_price`,
                    IF(`shop_orders`.`status` = 2, 1, 0) as `status`,
                    COUNT(`shop_orders_products`.`order_id`) as `products_count`,
                    SUM(`shop_orders_products`.`quantity`) as `quantity`,
                    IFNULL(`users`.`id`,'-') as `user_id`, 
                    IFNULL(`users`.`username`,'-') as `username`
                 FROM 
                    `shop_orders`
                 LEFT JOIN `shop_orders_products` ON `shop_orders_products`.`order_id` = `shop_orders`.`id`
                 LEFT JOIN `users` ON `shop_orders`.`user_id` = `users`.`id`
                 WHERE 1
                    AND FROM_UNIXTIME(`shop_orders`.`date_created`) <= NOW() + INTERVAL 1 DAY 
                    " . \mod_stats\classes\DateInterval::prepareDateBetweenCondition('date_created', $params) . "
                    {$otherConditions}
                 GROUP BY 
                   `shop_orders`.`id`
                 ORDER BY 
                   FROM_UNIXTIME(`shop_orders`.`date_created`)
                ) as dtable                  
            GROUP BY `username`
            {$orderBy}
        ";


        $result = $this->db->query($query);
        if ($result === FALSE) {
            return FALSE;
        }
        return $result->result_array();
    }

}

