<?php 

 use Base\SOrderStatusHistory as BaseSOrderStatusHistory;



/**
 * Skeleton subclass for representing a row from the 'shop_orders_status_history' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SOrderStatusHistory extends BaseSOrderStatusHistory {
    
    public function attributeLabels()
	{
		return array(
			'Id'=>ShopCore::t('Id'),
			'OrderId'=>ShopCore::t('Id Заказа'),
			'StatusId'=>ShopCore::t('Id Статуса'),
			'UserId'=>ShopCore::t('Id Менеджера'),
			'DateCreated'=>ShopCore::t('Дата изменения'),
			'Comment'=>ShopCore::t('Комментарий'),
		);
	}
    
    /**
     * Validation rules
     * 
     * @access public
     * @return array
     */
    public function rules()
    {
        return array(
           array(
                 'field'=>'OrderId',
                 'label'=>$this->getLabel('OrderId'),
                 'rules'=>'required|callback_order_id_check'
              ),
          array(
                 'field'=>'StatusId',
                 'label'=>$this->getLabel('StatusId'),
                 'rules'=>'required||callback_status_id_check'
              ),
          array(
                 'field'=>'Comment',
                 'label'=>$this->getLabel('Comment'),
                 'rules'=>'max_length[1000]'
              ),
        );
    }
    
    function order_id_check ($orderId = 0){
        $odrer = SOrdersQuery::create()
            ->findPk((int) $orderId);

        if ($odrer === null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    function status_id_check ($statusId = 0){
        $status = SOrderStatuses::create()
            ->findPk((int) $statusId);

        if ($status === null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    function user_id_check ($orderId = 0){        
        $ci =& get_instance();
        $ci->load->model('dx_auth/users', 'users');
	$ci->load->model('dx_auth/user_temp', 'user_temp');

	$users = $ci->users->get_user_by_id($orderId);

        if ($users === null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
} // SOrderStatusHistory
