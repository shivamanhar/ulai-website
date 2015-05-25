<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * @property SCategory $categoryModel
 */
class Category extends \ShopController {

    private $categoryClass;
    private $templateFile;
    private $data;
    private $perPage;

    public function __construct() {

        parent::__construct();

        \CMSFactory\Events::create()->registerEvent($this->data, 'category:preload');
        \CMSFactory\Events::runFactory();

        $categoryApi = \Category\CategoryApi::getInstance();

        // todo urlcatmanager
        $categoryPath = (\MY_Controller::getCurrentLocale() == $this->uri->segments[1]) ? implode('/', array_slice($this->uri->segments, 3)) : implode('/', array_slice($this->uri->segments, 2));

        $categoryModel = $categoryApi->findOneCategoryByFullPath($categoryPath, \MY_Controller::getCurrentLocale());

        ($categoryModel !== null) OR $this->core->error_404();

        try {
            $this->categoryClass = new \Category\BaseCategory($categoryModel);

            $this->core->core_data['data_type'] = 'shop_category';
            $this->core->core_data['id'] = $this->categoryClass->getCategory()->getId();

            /** Set userPerPage Products Count */
            $this->perPage = (intval(\ShopCore::$_GET['user_per_page'])) ? intval(\ShopCore::$_GET['user_per_page']) : $this->perPage = \ShopCore::app()->SSettings->frontProductsPerPage;
            /** Set template file */
            $this->templateFile = ($this->categoryClass->getCategory()->getTpl() == '') ? 'category' : (file_exists('./templates/' . $this->config->item('template') . '/shop/' . $this->categoryClass->getCategory()->getTpl() . '.tpl') ? $this->categoryClass->getCategory()->getTpl() : 'category');

            $this->data = $this->categoryClass->getProducts($this->perPage, (int) \ShopCore::$_GET['per_page'], \ShopCore::$_GET['order']);

            $this->index();
        } catch (\Exception $exc) {
            $this->core->error_404();
        }
    }

    public function index() {

        if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $this->template->add_array($this->data);
            $this->template->display('smart_filter/filter');
            exit;
        }


        $basePath = shop_url('category/' . $this->categoryClass->getCategory()->getFullPath() . SProductsQuery::getFilterQueryString());

        $this->categoryClass->installPagination($this->data, $basePath, $this->perPage);

        /* Seo block (canonical) */
        if ((!empty(\ShopCore::$_GET) || strstr($_SERVER['REQUEST_URI'], '?')) && (!\ShopCore::$_GET['per_page'])) {
            $this->template->registerCanonical(site_url($this->uri->uri_string()));
        }

        /* Set meta tags */
        $this->core->set_meta_tags(
                $this->categoryClass->getCategory()->makePageTitle(), $this->categoryClass->getCategory()->makePageKeywords(), $this->categoryClass->getCategory()->makePageDesc(), $this->data['page_number'], $this->categoryClass->getCategory()->getShowSiteTitle()
        );

        /** Register event 'category:load' */
        \CMSFactory\Events::create()->registerEvent($this->data, 'category:load');
        \CMSFactory\Events::runFactory();

        \CI_Controller::get_instance()->template->registerJsFile('/templates/' . $this->config->item('template') . '/smart_filter/js/jquery.ui-slider.js', 'after');
        \CI_Controller::get_instance()->template->registerJsFile('/templates/' . $this->config->item('template') . '/smart_filter/js/filter.js', 'after');

        /** Render template */
        $this->render($this->templateFile, $this->data);
        exit;
    }

}
