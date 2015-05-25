<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Shop Product Controller
 * @package Shop
 * @copyright 2013 ImageCMS
 * @author <dev
 * @property SProducts $model
 * @property Mod_discount $mod_discount
 */
class Product extends \Products\BaseProducts {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display product
     * @access public
     */
    public function index() {
        
        if ($this->model->getUrl() !== $this->productPath) {
            redirect('shop/product/' . $this->model->getUrl(), 'location', '301');
        }

        if (!empty(\ShopCore::$_GET) || strstr($this->input->server('REQUEST_URI'), '?')) {
            $this->template->registerCanonical(site_url($this->uri->uri_string()));
        }

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
            $fortitle = $this->model->getMainCategory()->buildCategoryPath(Criteria::DESC);
            $this->core->set_meta_tags($this->model->getId() . " - " . $this->model->getName(), $this->model->getMetaKeywords(), $description, '', 0, $fortitle[0]->getName());
        }

        \CMSFactory\Events::create()->registerEvent($this->data, 'product:load');
        \CMSFactory\Events::runFactory();

        $this->render($this->templateFile, $this->data);
        exit;
    }

}

/** End of file application/modules/shop/product.php  */