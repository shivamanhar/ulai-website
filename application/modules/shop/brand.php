<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Shop Brands Controller
 *
 * @uses ShopController
 * @package Shop
 * @version 0.1
 * @copyright 2013 ImageCMS
 * @author <dev
 * @property SBrands $model
 */
class Brand extends \Brands\BaseBrands {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display list of brand products.
     */
    public function index() {
        if ($this->brandPath == 'brand') {
            $this->core->set_meta_tags(lang('Бренды'));
            $this->renderImageList();
            //$this->renderNamesList();
        }

        if ($this->model == NULL) {
            $this->core->error_404();
        }

        if (!$this->category) {
            if ($this->model->getUrl() !== $this->brandPath) {
                redirect('shop/brand/' . $this->model->getUrl(), 'location', '301');
            }
        }
        // Begin pagination
        $this->load->library('Pagination');
        $this->pagination = new SPagination();
        $brandPagination['base_url'] = str_replace('/?', '?', shop_url('brand/' . $this->model->getUrl() . '/' . $this->category . SProductsQuery::getFilterQueryString()));
        $brandPagination['total_rows'] = $this->data['totalProducts'];
        $brandPagination['per_page'] = $this->perPage;
        $brandPagination['last_link'] = ceil($brandPagination["total_rows"] / $brandPagination["per_page"]);
        include_once "./templates/{$this->config->item('template')}/paginations.php";

        $this->pagination->initialize($brandPagination);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['page_number'] = $this->pagination->cur_page;
        // End pagination

        if ((!empty(\ShopCore::$_GET) || strstr($_SERVER['REQUEST_URI'], '?')) && (!\ShopCore::$_GET['per_page'])) {
            $this->template->registerCanonical(site_url($this->uri->uri_string()));
        }

        $title = $this->model->getMetaTitle() == '' ? $this->model->getName() : $this->model->getMetaTitle();

        if ($this->model->getMetaDescription()) {
            $description = $this->model->getMetaDescription();
        } else {
            $description = $this->model->getName();
        }
        $this->core->set_meta_tags($title, $this->model->getMetaKeywords(), $description, $this->pagination->cur_page, 0);

        \CMSFactory\Events::create()->registerEvent($this->data, 'brand:load');
        \CMSFactory\Events::runFactory();

        $this->render($this->data['template'], $this->data);
    }

}

/* End of file brand.php */

