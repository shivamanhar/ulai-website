<?php

class Shop_widgets extends ShopController {

    private $productsDefaults = array(
        'subpath' => 'widgets',
        'productsType' => 'popular',
        'productsCount' => 10,
        'title' => 'Popular products'
    );
    private $brandsDefaults = array(
        'subpath' => 'widgets',
        'brandsCount' => 15,
        'withImages' => true
    );
    private $similarDefaults = array(
        'title' => 'Similar products',
        'productsCount' => 5,
        'subpath' => 'widgets'
    );
    private $viewProductDefaults = array('subpath' => 'widgets');

    //featured products
    public function __construct() {
        parent::__construct();
    }

    public function view_product($widget) {
        $settings = $widget['settings'];
        $core_data = $this->core->core_data;


        $data = array(
            'products' => $this->showLastProducts($settings['productsCount']),
            'title' => $settings['title']);

        if ($core_data['data_type'] == 'product') {
            $this->addProduct($core_data['id'], $settings['productsCount']);
        }

        return $this->template->fetch('widgets/' . $widget['name'], $data);
    }

    public function addProduct($param = NULL, $limit = 4) {
        /**
         * Добавление первого продукта в массив.
         */
        if ($param != NULL) {
            if ($this->session->userdata('page') == false) {
                $pageId = array($param);
                $this->session->set_userdata('page', $pageId);
            } else {
                /**
                 * Если не существует такого продукта записываем новый, и удаляем последний.
                 */
                $pageId = array_unique($this->session->userdata('page'));
                if (!in_array($param, $pageId)) {
                    if (count($pageId) >= $limit) {
                        array_shift($pageId);
                    }

                    array_push($pageId, $param);
                    $this->session->set_userdata('page', $pageId);
                }
            }
        } else {
            log_message('error', 'Widget function "addProduct" product ID is not passed.');
            return false;
        }
    }

    /**
     * Вывод продукта.
     */
    public function showLastProducts($limit = 20) {
        /**
         * Вызываем сессию и извлекаем из нее все идентификаторы, и записываем в строку через запятую.
         */
        $pageId = $this->session->userdata('page');



        if (count($pageId) >= 1) {
//            array_pop($pageId);
            /**
             * Вытаскиваем все продукты из базы данных.
             */
            $model = SProductsQuery::create()
                    //->joinWithI18n(MY_Controller::getCurrentLocale())
                    ->filterById($pageId)
                    ->limit($limit)
                    ->filterByActive(true)
                    ->find();
            /**
             * Возвращаем все продукты в виде массива.
             */
            return $model;
        }
    }

    public function view_product_configure($mode = 'install_defaults', $data = array()) {
        if ($this->dx_auth->is_admin() == FALSE)
            exit;

        switch ($mode) {
            case 'install_defaults':
                $this->load->module('admin/widgets_manager')->update_config($data['id'], $this->viewProductDefaults);
                break;

            case 'show_settings':
                $this->render('view_product_form', array('widget' => $data));
                break;

            case 'update_settings':

                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', lang('Widget title', 'main'), 'trim|xss_clean');

                if ($this->form_validation->run()) {

                    $settings = array(
                        'productsType' => $this->input->post('productsType'),
                        'title' => $this->input->post('title'),
                        'productsCount' => $this->input->post('productsCount'),
                        'subpath' => 'widgets'
                    );

                    $this->load->module('admin/widgets_manager')->update_config($data['id'], $settings);
                    showMessage(lang('Successfully saved'));

                    if ($this->input->post('action') == 'tomain') {
                        pjax('/admin/widgets_manager');
                    } else {
                        pjax('');
                    }
                } else {
                    showMessage($this->form_validation->error_string(), '', 'r');
                }

                break;

            default :
                return false;
                break;
        }
    }

    public function products($widget) {

        $hash = $_SERVER['REQUEST_URI'] . $widget['name'];
        if ($cahe = Cache_html::get_html($hash))
            return $cahe;
        else {


            $settings = $widget['settings'];

            $data = array(
                'products' => $this->getPromoBlock($settings['productsType'], $settings['productsCount']),
                'title' => $settings['title']);

            $widget_to_view = $this->template->fetch('widgets/' . $widget['name'], $data);

            Cache_html::set_html($widget_to_view, $hash);

            return $widget_to_view;
        }
    }

    public function products_configure($mode = 'install_defaults', $data = array()) {
        if ($this->dx_auth->is_admin() == FALSE)
            exit;

        switch ($mode) {
            case 'install_defaults':
                $this->load->module('admin/widgets_manager')->update_config($data['id'], $this->productsDefaults);
                break;

            case 'show_settings':
                $this->render('products_form', array('widget' => $data));
                break;

            case 'update_settings':

                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', lang('Widget title'), 'trim|xss_clean');
                $this->form_validation->set_rules('productsCount', lang('Number of items to display'), 'numeric|required');

                if ($this->form_validation->run()) {

                    $productType = implode(',', $this->input->post('productsType'));

                    $settings = array(
                        'productsType' => $productType,
                        'title' => $this->input->post('title'),
                        'productsCount' => $this->input->post('productsCount'),
                        'subpath' => 'widgets'
                    );

                    $this->load->module('admin/widgets_manager')->update_config($data['id'], $settings);
                    showMessage(lang('Successfully saved'));

                    if ($this->input->post('action') == 'tomain') {
                        pjax('/admin/widgets_manager');
                    } else {
                        pjax('');
                    }
                } else {
                    showMessage($this->form_validation->error_string(), '', 'r');
                }

                break;

            default :
                return false;
                break;
        }
    }

    //end of featured products
    //brands

    public function brands($widget) {

        if ($cahe = Cache_html::get_html($widget['name'])) {
            return $cahe;
        } else {
            $settings = $widget[settings];

            $data = array(
                'settings' => $settings,
                'title' => $settings[title],
                'brands' => ShopCore::app()->SBrandsHelper->mostProductBrands($settings[brandsCount], $settings[withImages])
            );
            $widget_to_view = $this->template->fetch('widgets/' . $widget['name'], $data);
            Cache_html::set_html($widget_to_view, $widget['name']);
            return $widget_to_view;
        }
    }

    public function brands_configure($mode = 'install_defaults', $data = array()) {
        if ($this->dx_auth->is_admin() == FALSE) {
            exit;
        }

        switch ($mode) {
            case 'install_defaults':
                $this->load->module('admin/widgets_manager')->update_config($data['id'], $this->brandsDefaults);
                break;

            case 'show_settings':
                $this->render('brands_form', array('widget' => $data));
                break;

            case 'update_settings':

                $this->load->library('form_validation');
                $this->form_validation->set_rules('brandsCount', lang('Number of items to display'), 'numeric|required');

                if ($this->form_validation->run()) {
                    $settings = array(
                        'withImages' => (bool) $this->input->post('withImages'),
                        'brandsCount' => $this->input->post('brandsCount'),
                        'subpath' => 'widgets',
                        'title' => $this->input->post('title')
                    );

                    $this->load->module('admin/widgets_manager')->update_config($data['id'], $settings);
                    showMessage(lang('Successfully saved'));

                    if ($this->input->post('action') == 'tomain')
                        pjax('/admin/widgets_manager');
                    else
                        pjax('');
                } else
                    showMessage($this->form_validation->error_string(), '', 'r');

                break;

            default :
                return false;
                break;
        }
    }

    //end of brands
    //

    public function similar_products($widget) {

        $settings = $widget['settings'];
        $data = array(
            'settings' => $settings,
            'title' => $settings['title']
        );


        return $this->template->fetch('widgets/' . $widget['name'], $data);
    }

    public function similar_products_configure($mode = 'install_defaults', $data = array()) {
        if ($this->dx_auth->is_admin() == FALSE)
            exit;

        switch ($mode) {
            case 'install_defaults':
                $this->load->module('admin/widgets_manager')->update_config($data['id'], $this->similarDefaults);
                break;

            case 'show_settings':
                $this->render('similar_products_form', array('widget' => $data));
                break;

            case 'update_settings':

                $this->load->library('form_validation');
                $this->form_validation->set_rules('productsCount', lang('Number of items to display'), 'numeric|required');

                if ($this->form_validation->run()) {
                    $settings = array(
                        'title' => $this->input->post('title'),
                        'productsCount' => $this->input->post('productsCount'),
                        'subpath' => 'widgets'
                    );

                    $this->load->module('admin/widgets_manager')->update_config($data['id'], $settings);
                    showMessage(lang('Successfully saved'));

                    if ($this->input->post('action') == 'tomain')
                        pjax('/admin/widgets_manager');
                    else
                        pjax('');
                } else
                    showMessage($this->form_validation->error_string(), '', 'r');

                break;

            default :
                return false;
                break;
        }
    }

    //end of brands

    public function render($viewName, array $data = array(), $return = false) {
        if (!empty($data)) {
            $this->template->add_array($data);
        }

        if ($return === false) {
            if ($this->input->is_ajax_request()) {
                $this->template->display('file:' . getModulePath('shop') . 'widgets/templates/' . $viewName);
            } else {
                $this->template->show('file:' . getModulePath('shop') . 'widgets/templates/' . $viewName);
            }
        } else {
            return $this->template->fetch('file:' . getModulePath('shop') . 'widgets/templates/' . $viewName);
        }

        exit;
    }

    public function getPromoBlock($type = 'action', $limit = 10, $idCategory = NULL, $idBrand = NULL) {
        $model = SProductsQuery::create()
                ->joinWithI18n(ShopController::getCurrentLocale())
                ->orderByCreated('DESC');
        if ($idCategory) {
            $model = $model->filterByCategoryId($idCategory);
        }
        if ($idBrand) {
            $model = $model->filterByBrandId($idBrand);
        }
        if (strpos($type, 'hit')) {
            $model = $model->_or()->filterByHit(true);
        }
        if (strpos($type, 'hot')) {
            $model = $model->_or()->filterByHot(true);
        }
        if (strpos($type, 'action')) {
            $model = $model->_or()->filterByAction(true);
        }
        if (strpos($type, 'oldPrice')) {
            $model = $model->filterByOldPrice(array('min' => true));
        }
        if (strpos($type, 'category') AND ( $categoryId = filterCategoryId()) !== false) {
            $model = $model->useShopProductCategoriesQuery()->filterByCategoryId($categoryId)->endUse();
        }
        if (strpos($type, 'popular')) {
            
        }
        $model = $model->useMainCategoryQuery()->filterBy('Active', TRUE)->endUse();
        // $model = $model->where('SProducts.Views > ?', 1)->orderByViews(Criteria::DESC);
        if (strpos($type, 'date')) {
            $model = $model->orderByUpdated(Criteria::DESC);
        }
        $model = $model->filterByActive(true)->limit($limit)->find();

        return $model;
    }

}

?>
