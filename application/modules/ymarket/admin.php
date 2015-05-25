<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Image CMS 
 * Sample ymarket Admin
 * @property Ymarket_model $ymarket_model 
 */
class Admin extends BaseAdminController {

    public function __construct() {
        parent::__construct();
        $lang = new MY_Lang();
        $lang->load('ymarket');
        $this->load->model('ymarket_model');        
        
        if(!$this->load->module('admin/components')->is_installed('ymarket')){
            $this->core->error_404();
        }
    }
    
    /**
     * Connects the module template in the administrative part of the site
     */
    public function index() {
        $item = $this->getSelectedCats();

        \CMSFactory\assetManager::create()
                ->setData('hold',$item)
                ->renderAdmin('list');
    }
    
    /**
     * Selecting categories to generate xml
     * @return obj category, check adult and ids selectet category
     */
    public function getSelectedCats() {
        $data->categories = ShopCore::app()->SCategoryTree->getTree();
        $data->ymarket_model = $this->ymarket_model->init();
        return $data;      
    }
    
    /**
     * Saves the selected user categories in the table
     */
    public function save() {
        if(isset($_POST) && $this->dx_auth->is_admin()){
            $this->ymarket_model->setCategories();
            $this->lib_admin->log(lang("Yandex marker settings was edited", "ymarket"));
        }
    } 
}
