<?php
/**
 * SMemCached - Cache shop pages
 */
 
class SMobileVersion {

    private $expire;
    private $settings;

    public function __construct(){
        $this->loadSettings();
    }
    
    public function loadSettings(){
        $model = ShopSettingsQuery::create()
                ->filterByName('MobileVersionSettings')
                ->findOne();
        
        if (sizeof($model) > 0)
            $this->settings = unserialize($model->getValue());
        
        else {
            $this->settings['MobileVersionON'] = FALSE;
            $this->settings['MobileVersionAddress'] = 'mobile.localhost';
            $this->settings['MobileVersionSite'] = 'localhost';
            $this->settings['MobileVersionTemplate'] = './templates/commerce_mobile/shop/default';
            
            $model = new ShopSettings();
            $model->setName('MobileVersionSettings');
            $model->setValue(serialize($this->settings));
            $model->save();
        }
        
        return $this->settings;
    }
}