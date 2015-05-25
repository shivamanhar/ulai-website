<?php

class smart_filter extends \MY_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function init(){
        
        \CMSFactory\Events::create()->registerEvent(null, 'smartFilter:init');
        \CMSFactory\Events::runFactory();     
        $this->template->display('smart_filter/main');
        
    }
    
    public function filter(){
        
        \CMSFactory\Events::create()->registerEvent(null, 'smartFilter:filter');
        \CMSFactory\Events::runFactory();
        $this->load->module('shop/category');
    }
    

}