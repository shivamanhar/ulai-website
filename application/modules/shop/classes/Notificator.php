<?php

/**
 * Notificator
 * check `shop_notifications` when changing product quantity
 * and send notifications
 * 
 * 
 * usage:
 *         Notificator::run();
 *         Notificator::run(17592);
 * 
 * 
 * 
 * @author Cray
 */
class Notificator {

    public static function run($productId = NULL)
    {
        if (isset($productId)) {

            $ids = self::searchByProductId($productId);
        } else {

            $ids = self::searchAll();
        }

        $notificationsForSend = self::checkProducts($ids);

//        var_dumps_exit($notificationsForSend);


        /**
         * @todo set notified_by_id = 1
         */
        self::sendNotifications($notificationsForSend);
    }

    /**
     * search products whith stock > 0
     * @param array $ids
     * @return array
     */
    protected static function checkProducts($ids)
    {
        $notifForSend = [];

        foreach ($ids as $notifId => $variantId) {
            $var = SProductVariantsQuery::create()
                    ->where('SProductVariants.Id = ?', $variantId)
                    ->where('SProductVariants.Stock > ?', 0)
                    ->find();
            if (count($var)) {
                $notifForSend [] = $notifId;
            }
        }
        return $notifForSend;
    }

    /**
     * search all notifications by product id
     * @param int $id
     * @return array [notificationId=>variantId]
     */
    protected static function searchByProductId($id)
    {
        $models = SNotificationsQuery::create()->findByArray([
            'notifiedByEmail' => FALSE,
            'productId' => $id
        ]);
        foreach ($models as $mod) {
            $ids [$mod->getId()] = $mod->getVariantId();
        }
        return $ids;
    }

    /**
     * search all notifications
     * @return array [notificationId=>variantId]
     */
    protected static function searchAll()
    {
        $models = SNotificationsQuery::create()->findByNotifiedByEmail(FALSE);
        foreach ($models as $mod) {
            $ids [$mod->getId()] = $mod->getVariantId();
        }
        return $ids;
    }

    /**
     * send notifications
     * @param array $notificationIds
     * @return void
     */
    protected static function sendNotifications(array $notificationIds = array())
    {
        if (!empty($notificationIds)) {
            foreach ($notificationIds as $id) {
                self::notifyByEmail($id);
            }
        }
    }

    /**
     *  send notification by id
     *  @param int $notificationId
     */
    protected static function notifyByEmail($notificationId)
    {
        
        $model = SNotificationsQuery::create()
                ->findPk($notificationId);

        if ($model->getNotifiedByEmail() != true) {
            $model->setNotifiedByEmail(true);
            $model->save();
        }

        $product = SProductsQuery::create()->findPk($model->getProductId());
        if ($product) {
            \cmsemail\email::getInstance()->sendEmail(
                    $model->getUserEmail(), 'notification_email', array(
                'status' => $model->getSNotificationStatuses()->getName(),
                'userName' => $model->getUserName(),
                'userEmail' => $model->getUserEmail(),
                'productName' => $product->getName(),
                'productLink' => shop_url('product/' . $product->getUrl())
            ));
        }
    }

}
