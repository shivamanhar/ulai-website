<?php 

 use Base\SNotifications as BaseSNotifications;



/**
 * Skeleton subclass for representing a row from the 'shop_notifications' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SNotifications extends BaseSNotifications {
    
    public function attributeLabels()
	{
		return array(
			'Status'=>ShopCore::t('Статус'),
			'Sent'=>ShopCore::t('Отправлен'),
			'UserName'=>ShopCore::t('Имя пользователя'),
			'UserEmail'=>ShopCore::t('Почта'),
			'UserPhone'=>ShopCore::t('Номер телефона'),
			'UserComment'=>ShopCore::t('Комментарий'),
			'DateCreated'=>ShopCore::t('Дата создания'),
                        'ActiveTo'=>ShopCore::t('Актуальный до'),
                        'Manager'=>ShopCore::t('Менеджер'),
                        'NotifyByEmail'=>ShopCore::t('Уведомить по E-mail'), 
                        'Product'=>ShopCore::t('Товар'),
                        'Manager'=>ShopCore::t('Статус установил'),
		);
	}

} // SNotifications
