<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * @author Gula Andrew <a.gula
 */
class Admin extends BaseAdminController
{

    public function __construct()
    {
        parent::__construct();
        $lang = new MY_Lang();
        $lang->load('trash');

        $this->load->library('DX_Auth');

        \CMSFactory\assetManager::create()->registerScript('script');
        //cp_check_perm('module_admin');
    }

    public function search_url($type_search = 'old')
    {
        $type_search = $type_search == 'old' ? 'old' : 'new';
        // old = старый урл, new - новый урл
        if ($this->input->get()) {
            $get = $this->input->get();
            if ($type_search == 'old') {
                $this->db->select("id, trash_url as text");
                $this->db->like("trash_url", $get['term'], 'both');
            } else {
                $this->db->select("id, trash_redirect as text");
                $this->db->like("trash_redirect", $get['term'], 'both');
            }

            $this->db->order_by("id", "DESC");
            $this->db->limit(100);
            $result = $this->db->get("trash")->result_array();
            $json_answer = array();
            if ($result) {
                foreach ($result as $res) {
                    $json_answer[] = array(
                        'value' => $res['text'],
                        'identifier' => array(
                            'id' => $res['id']
                        )
                    );
                }
                return json_encode($json_answer);
            } else {
                return json_encode(array());
            }
        }
    }

    public function index()
    {
        $countTotalRows = (int)$this->db->get('trash')->num_rows();
        $perPage = (int)$this->input->get('per_page');
        if (empty($perPage)) {
            $perPage = 0;
        }
        $this->db->offset($perPage);
        $this->db->limit(25);
        $query = $this->db->get('trash')->result();

        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/components/cp/trash?');
        $config['uri_segment'] = $perPage;
        $config['total_rows'] = $countTotalRows;
        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $this->pagination->num_links = 5;
        $this->pagination->initialize($config);

        \CMSFactory\assetManager::create()
            ->setData('model', $query)
            ->setData('pagination', $this->pagination->create_links_ajax())
            ->registerScript("admin")
            ->renderAdmin('main');
    }

    function create_trash_list()
    {
        $this->display_tpl('create_trash_list');
    }

    function trash_list()
    {
        if ($this->input->post('urls')) {
            $data = nl2br($this->input->post('urls'));
            $data = explode('<br />', $data);
            $data = array_map('trim', $data);
            $data = array_filter($data);

            $this->load->module('trash');

            foreach ($data as $value) {

                $value = explode(' ', $value);
                try {
                    $this->trash->create_redirect($value[0], $value[1], $value[2]);
                    $this->lib_admin->log(lang("Trash created", "trash") . '. Id:' . $this->db->insert_id());

                } catch (Exception $exc) {
                    showMessage($exc->getMessage(), FALSE, 'r');
                    exit;
                }
            }

            showMessage(lang('Trash list has been created', 'trash'));

            if ($this->input->post('action') == 'exit') {
                pjax('/admin/components/init_window/trash');
            }
        } else {
            showMessage(lang('Error', 'admin'), FALSE, 'r');
        }
    }

    function create_trash()
    {
        $this->form_validation->set_rules('url', 'Url', 'required');

        $this->db->where('name', 'shop')->get('components');

        if (count($this->db->where('name', 'shop')->get('components')->row()) > 0) {

            $query = $this->db
                ->where('locale', MY_Controller::getCurrentLocale())
                ->order_by('name', 'asc')
                ->get('shop_products_i18n');
            $this->template->add_array(array('products' => $query->result()));

            $this->db->order_by("name", "asc");
            $query = $this->db
                ->where('locale', MY_Controller::getCurrentLocale())
                ->get('shop_category_i18n');
            $this->template->add_array(array('category' => $query->result()));
        }

        //$this->db->order_by("name", "asc");
        //$query = $this->db->get('category');

        $lang_identif = $this->db
            ->where('identif', MY_Controller::getCurrentLocale())
            ->get('languages')
            ->row();

        $query = $this->db
            ->where('lang', (int)$lang_identif->id)
            ->join('category_translate', 'category_translate.alias = category.id')
            ->get('category');

        $this->template->add_array(array('category_base' => $query->result()));

        ($this->ajaxRequest) OR $this->display_tpl('create_trash');

        if ($_POST) {
            if ($this->form_validation->run($this) == FALSE) {
                showMessage(validation_errors(), '', 'r');
            } else {

                switch ($this->input->post('redirect_type')) {

                    case "url":
                        $array = array(
                            'trash_url' => ltrim($this->input->post('url'), '/'),
                            'trash_redirect_type' => $this->input->post('redirect_type'),
                            'trash_type' => $this->input->post('type'),
                            'trash_redirect' => 'http://' . ltrim($this->input->post('redirect_url'), 'http://')
                        );
                        break;

                    case "product":
                        $query = $this->db->get_where('shop_products', array('id' => $this->input->post('products')));
                        $url = $query->row();
                        $array = array(
                            'trash_id' => $this->input->post('products'),
                            'trash_url' => ltrim($this->input->post('url'), '/'),
                            'trash_redirect_type' => $this->input->post('redirect_type'),
                            'trash_type' => $this->input->post('type'),
                            'trash_redirect' => site_url() . 'shop/product/' . $url->url
                        );
                        break;

                    case "category":
                        $query = $this->db->get_where('shop_category', array('id' => $this->input->post('category')));
                        $url = $query->row();
                        $array = array(
                            'trash_id' => $this->input->post('category'),
                            'trash_url' => ltrim($this->input->post('url'), '/'),
                            'trash_redirect_type' => $this->input->post('redirect_type'),
                            'trash_type' => $this->input->post('type'),
                            'trash_redirect' => site_url() . 'shop/category/' . $url->full_path
                        );
                        break;

                    case "basecategory":
                        $query = $this->db->get_where('category', array('id' => $this->input->post('category_base')));
                        $url = $query->row();
                        $array = array(
                            'trash_id' => $this->input->post('category_base'),
                            'trash_url' => ltrim($this->input->post('url'), '/'),
                            'trash_redirect_type' => $this->input->post('redirect_type'),
                            'trash_type' => $this->input->post('type'),
                            'trash_redirect' => site_url($this->cms_base->get_category_full_path($url->id))
                        );
                        break;

                    case "404":
                        $array = array(
                            'trash_url' => ltrim($this->input->post('url'), '/'),
                            'trash_redirect_type' => '404'
                        );
                        break;

                    default :
                        $array = array(
                            'trash_url' => ltrim($this->input->post('url'), '/'),
                            'trash_redirect_type' => '404'
                        );
                        break;
                }

                $this->db->set($array);
                $this->db->insert('trash');
                $lastId = $this->db->insert_id();

                showMessage(lang('Trash was created', 'trash'));

                $this->lib_admin->log(lang("Trash was created", "trash") . '. Url: ' . $array['trash_url']);

                if ($this->input->post('action') == 'create') {
                    pjax('/admin/components/init_window/trash/edit_trash/' . $lastId);
                }
                if ($this->input->post('action') == 'exit') {
                    pjax('/admin/components/init_window/trash');
                }
            }
        }
    }

    function edit_trash($id)
    {
        $query = $this->db->get_where('trash', array('id' => $id));
        $this->template->add_array(array('trash' => $query->row()));

        if (count($this->db->get_where('components', array('name' => 'shop'))->row()) > 0) {
            $this->db->order_by("name", "asc");
            $query = $this->db->get('shop_products_i18n');
            $this->template->add_array(array('products' => $query->result()));

            $this->db->order_by("name", "asc");
            $query = $this->db->get('shop_category_i18n');
            $this->template->add_array(array('category' => $query->result()));
        }

        $this->db->order_by("name", "asc");
        $query = $this->db->get('category');
        $this->template->add_array(array('category_base' => $query->result()));

        if (!$this->ajaxRequest) {
            $this->display_tpl('edit_trash');
        }

        if ($_POST) {
            switch ($this->input->post('redirect_type')) {
                case "url":
                    $array = array(
                        'id' => $this->input->post('id'),
                        'trash_url' => $this->input->post('old_url'),
                        'trash_redirect_type' => $this->input->post('redirect_type'),
                        'trash_type' => $this->input->post('type'),
                        'trash_redirect' => prep_url($this->input->post('redirect_url'))
                    );
                    break;

                case "product":
                    $query = $this->db->get_where('shop_products', array('id' => $this->input->post('products')));
                    $url = $query->row();

                    $array = array(
                        'id' => $this->input->post('id'),
                        'trash_id' => $this->input->post('products'),
                        'trash_url' => $this->input->post('old_url'),
                        'trash_redirect_type' => $this->input->post('redirect_type'),
                        'trash_type' => $this->input->post('type'),
                        'trash_redirect' => site_url() . 'shop/product/' . $url->url
                    );
                    break;

                case "category":
                    $query = $this->db->get_where('shop_category', array('id' => $this->input->post('category')));
                    $url = $query->row();

                    $array = array(
                        'id' => $this->input->post('id'),
                        'trash_id' => $this->input->post('category'),
                        'trash_url' => $this->input->post('old_url'),
                        'trash_redirect_type' => $this->input->post('redirect_type'),
                        'trash_type' => $this->input->post('type'),
                        'trash_redirect' => site_url() . 'shop/category/' . $url->full_path
                    );
                    break;

                case "basecategory":
                    $query = $this->db->get_where('category', array('id' => $this->input->post('category_base')));
                    $url = $query->row();

                    $array = array(
                        'id' => $this->input->post('id'),
                        'trash_id' => $this->input->post('category_base'),
                        'trash_url' => $this->input->post('old_url'),
                        'trash_redirect_type' => $this->input->post('redirect_type'),
                        'trash_type' => $this->input->post('type'),
                        'trash_redirect' => site_url($this->cms_base->get_category_full_path($url->id))
                    );
                    break;

                case "404":
                    $array = array(
                        'id' => $this->input->post('id'),
                        'trash_url' => $this->input->post('old_url'),
                        'trash_redirect_type' => $this->input->post('redirect_type')
                    );
                    break;

                default :
                    $array = array(
                        'id' => $this->input->post('id'),
                        'trash_url' => $this->input->post('old_url'),
                        'trash_redirect_type' => $this->input->post('redirect_type')
                    );
                    break;
            }

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('trash', $array);
            $this->lib_admin->log(lang("Trash was edited", "trash") . '. Url: ' . $array['trash_url']);
        }

        if ($this->input->post('action')) {
            showMessage(lang('Successfully saved', 'trash'));
        }
        if ($this->input->post('action') == 'exit') {
            pjax('/admin/components/init_window/trash');
        }
    }

    function delete_trash()
    {
        foreach ($_POST['ids'] as $item) {
            $this->db->where('id', $item);
            $this->db->delete('trash');
        }
        $this->lib_admin->log(lang("Redirect was deleted.", "trash"));
    }

    private function display_tpl($file = '')
    {
        $file = realpath(dirname(__FILE__)) . '/templates/admin/' . $file;
        $this->template->show('file:' . $file);
    }

}

/* End of file admin.php */