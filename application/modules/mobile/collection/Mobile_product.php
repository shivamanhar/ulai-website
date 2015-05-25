<?php

namespace mobile\collection;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @uses Products.BaseProducts
 * @author A.Gula <dev
 * @copyright (c) 2013, ImageCMS
 * @package Shop.ImageCMSModule
 */
class Mobile_product extends \Products\BaseProducts {

    protected static $_instance;

    public function __construct() {
        parent::__construct();
        $lang = new \MY_Lang();
        $lang->load('mobile');
    }

    public function index() {
        $this->data['delivery_methods'] = \SDeliveryMethodsQuery::create()->find();
        $this->data['payments_methods'] = \SPaymentMethodsQuery::create()->find();
       
        if ($this->model->getMetaDescription()) {
            $description = $this->model->getMetaDescription();
        } else {
            $description = $this->model->getId() . " - " . $this->model->getName() . mb_substr($this->model->getFullDescription(), 0, 100, 'utf-8');
        }

        if ($this->model->getMetaTitle()) {
            $this->core->set_meta_tags($this->model->getMetaTitle(), $this->model->getMetaKeywords(), $description, '', 0);
        } else {
            $fortitle = $this->model->getMainCategory()->buildCategoryPath(\Criteria::DESC);
            $this->core->set_meta_tags($this->model->getId() . " - " . $this->model->getName(), $this->model->getMetaKeywords(), $description, '', 0, $fortitle[0]->getName());
        }

        \CMSFactory\Events::create()->registerEvent($this->data, 'product:load');
        \CMSFactory\Events::runFactory();
        
        $this->render($this->templateFile, $this->data);
    }

    /**
     * @return bool
     * @access public
     * @author Kaero
     * @copyright ImageCMS (c) 2013, Kaero <dev
     */
    public static function init() {
        (null !== self::$_instance) OR self::$_instance = new self();
        return TRUE;
    }

}