<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Cache $cache
 * @property Cms_admin $cms_admin
 */
class Settings extends BaseAdminController {

    /**
     * If TRUE then data will be save for each locale separately
     * @var boolean
     */
    protected $siteInfoLocales = FALSE;

    /**
     * Upload path for images (logo and favicon)
     * @var string
     */
    protected $uploadPath = 'uploads/images/';

    function __construct() {
        parent::__construct();

        $this->load->library('DX_Auth');
        admin_or_redirect();

        $this->load->library('lib_admin');
        $this->load->library('lib_category');
        $this->lib_admin->init_settings();
    }

    function index() {

//        $this->cms_admin->get_langs();
        //cp_check_perm('cp_site_settings');

        $settings = $this->cms_admin->get_settings();
        unset($settings['siteinfo']);

        $locale = $this->db->select('identif')->where('default', 1)->get('languages')->row_array();
        $this->load->library('SiteInfo', $locale['identif']);

        $siteinfo = $siteinfo = $this->siteinfo->getSiteInfoData(TRUE);

        if (is_array($siteinfo)) {
            $this->template->add_array($siteinfo);
        }

        $this->template->add_array($settings);
        $this->template->assign('templates', $this->_get_templates());
        $this->template->assign('template_selected', $settings['site_template']);

        // Передає змінну статусу роботів

        $this->template->assign('robots_settings_status', $settings['robots_settings_status']);
        $this->template->assign('robots_settings', $settings['robots_settings']);
        $this->template->assign('robots_status', $settings['robots_status']);

        $this->template->assign('work_values', array('yes' => lang("Yes", "admin"), 'no' => lang("No", "admin")));
        $this->template->assign('site_offline', $settings['site_offline']);


        $this->config->set_item('cur_lang', $this->load->module('core')->def_lang[0]['id']);
        $this->template->assign('tree', $this->lib_category->build());

        $this->template->assign('parent_id', $settings['main_page_cat']);
        $this->template->assign('id', 0);

///++++++++++++++++++++

        $langs = $this->db->get('languages')->result_array();
        $lang_meta = array();
        foreach ($langs as $lang) {
            $meta = $this->db->where('lang_ident', $lang['id'])->limit(1)->get('settings_i18n')->result_array();
            if (count($meta) > 0)
                $lang_meta[$lang['id']] = $meta[0];
            else
                $lang_meta[$lang['id']] = null;
        }

        $this->template->assign('langs', $langs);

        $this->template->assign('meta_langs', $lang_meta);

//++++++++++++++++++++

        ($hook = get_hook('admin_show_settings_tpl')) ? eval($hook) : NULL;

// Load modules list
        $notAvailableModules = array('mainsaas', 'saas');
        $this->template->assign('modules', $this->db->where_not_in('name', $notAvailableModules)->get('components')->result_array());

        $this->template->show('settings_site', FALSE);
    }

//++++++++++++++
    public function translate_meta() {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', lang('Name', 'admin'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('short_name', lang('Short name', 'admin'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', lang('Description', 'admin'), 'trim|xss_clean');
        $this->form_validation->set_rules('keywords', lang('Keywords', 'admin'), 'trim|xss_clean');

        if ($this->form_validation->run($this) == FALSE) {
            showMessage(validation_errors(), false, 'r');
        } else {
            $name = $this->input->post('name');
            $short_name = $this->input->post('short_name');
            $desk = $this->input->post('description');
            $key = $this->input->post('keywords');
            $lang = $this->input->post('lang_ident');
            if (count($this->db->where('lang_ident', $lang)->get('settings_i18n')->result_array())) {
                $this->db->query("UPDATE settings_i18n
                                                            SET
                                                                name = '$name',
                                                                short_name = '$short_name',
                                                                description = '$desk',
                                                                keywords = '$key'
                                                            WHERE lang_ident = '$lang'");
            } else {
                $this->db->query("INSERT INTO settings_i18n(
                                                                lang_ident,
                                                                name,
                                                                short_name,
                                                                description,
                                                                keywords
                                                                )
                                                            VALUES(
                                                                '$lang',
                                                                '$name',
                                                                '$short_name',
                                                                '$desk',
                                                                '$key')");
            }
        }
    }

//+++++++++++++++++++++++++++++++++++++++++
    /**
     * Main Page settings
     */
    function main_page() {
        $this->template->assign('tree', $this->lib_category->build());

        $settings = $this->cms_admin->get_settings();

        $this->template->add_array($settings);
        $this->template->assign('parent_id', $settings['main_page_cat']);
        $this->template->assign('id', 0);

        $this->template->show('settings_main_page', FALSE);
    }

    /**
     * Search templates in TEMPLATES_PATH folder
     *
     * @access private
     * @return array
     */
    function _get_templates() {
        $new_arr_shop = array();
        if ($handle = opendir(TEMPLATES_PATH)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && $file != 'administrator' && $file != 'modules' && !stristr($file, '_mobile')) {
                    if (!is_file(TEMPLATES_PATH . $file)) {
                        if (SHOP_INSTALLED && is_dir(TEMPLATES_PATH . $file . '/shop/')) {
                            $new_arr_shop[$file] = $file;
                        }
                        $new_arr[$file] = $file;
                    }
                }
            }
            closedir($handle);
        } else {
            return FALSE;
        }

        if (SHOP_INSTALLED) {
            array_multisort($new_arr_shop);
            return $new_arr_shop;
        } else {
            array_multisort($new_arr);
            return $new_arr;
        }
    }

    /**
     * Save site settings
     *
     * @access public
     */
    function save() {
        //cp_check_perm('cp_site_settings');
        switch ($this->input->post('main_type')) {
            case 'category':
                $data = array(
                    'main_type' => 'category',
                    'main_page_cat' => $this->input->post('main_page_cat'),
                );

                $this->cms_admin->save_settings($data);
                break;

            case 'page':
                if ($this->cms_admin->page_exists($this->input->post('main_page_pid'))) {
                    $data = array(
                        'main_type' => 'page',
                        'main_page_id' => $this->input->post('main_page_pid')
                    );

                    $this->cms_admin->save_settings($data);
                } else {
                    showMessage(lang("Page has not been found", "admin"), false, 'r');
                    exit;
                }
                break;

            case 'module':
                $data = array(
                    'main_type' => 'module',
                    'main_page_module' => $this->input->post('main_page_module'),
                );
                $this->cms_admin->save_settings($data);
                break;
        }

        $res = $this->processSiteInfo();

        $data_m = array(
            'create_keywords' => $this->input->post('create_keywords'),
            'create_description' => $this->input->post('create_description'),
            'create_cat_keywords' => $this->input->post('create_cat_keywords'),
            'create_cat_description' => $this->input->post('create_cat_description'),
            'add_site_name' => $this->input->post('add_site_name'),
            'add_site_name_to_cat' => $this->input->post('add_site_name_to_cat'),
            'delimiter' => $this->input->post('delimiter'),
            'cat_list' => $this->input->post('cat_list'),
            'editor_theme' => $this->input->post('editor_theme'),
            'site_offline' => $this->input->post('site_offline'),
            'google_analytics_id' => $this->input->post('google_analytics_id'),
            'google_webmaster' => $this->input->post('google_webmaster'),
            'yandex_webmaster' => $this->input->post('yandex_webmaster'),
            'yandex_metric' => $this->input->post('yandex_metric'),
            'site_template' => $this->input->post('template'),
            'lang_sel' => $this->input->post('lang_sel'),
            'text_editor' => $this->input->post('text_editor'),
            'robots_status' => (int) $this->input->post('robots_status'),
            'robots_settings_status' => (int) $this->input->post('robots_settings_status'),
            'robots_settings' => $this->input->post('robots_settings')
                //'siteinfo' => serialize($siData)
        );


        /** Save template path for shop * */
        if ($this->db->table_exists('shop_settings')) {
            $shopTemplatePath = './templates/' . $this->input->post('template') . '/shop/';
            $this->db->where('name', 'systemTemplatePath')->update('shop_settings', array('value' => $shopTemplatePath));
        }

        $this->replaceRobots($data_m['robots_status']);


        $this->translate_meta();

        //($hook = get_hook('admin_save_settings')) ? eval($hook) : NULL;


        $this->cms_admin->save_settings($data_m);


        $this->cache->delete_all();

        $this->lib_admin->log(lang("Changed wesite settings", "admin"));

        echo "<script>var textEditor = '{$data_m['text_editor']}';</script>";
        if (!validation_errors()) {
            showMessage(lang("Settings have been saved", "admin"));
        }
    }

    /**
     * Replace robots
     * @param int $robotsStatus - robots status(turn on - 1, turn off - 0)
     * @return int
     */
    private function replaceRobots($robotsStatus = 0) {
        $robots = file('robots.txt');
        if (!(int) $robotsStatus) {
            // Turn on robots
            $turnOnRobot = TRUE;

            foreach ($robots as $key => $robot) {
                if (trim($robot) == 'Disallow: /') {
                    $turnOnRobot = FALSE;
                    break;
                }

                if (trim($robot) == 'Disallow:') {
                    unset($robots[$key]);
                }
            }

            if ($turnOnRobot) {
                array_splice($robots, 1, 0, 'Disallow: /' . PHP_EOL);
                $this->lib_admin->log(lang("Robots was closed - ", "admin") . $this->input->ip_address());
            }
        } else {
            // Turn off robots
            $turnOffRobot = TRUE;

            foreach ($robots as $key => $robot) {
                if (trim($robot) == 'Disallow:') {
                    $turnOffRobot = FALSE;
                    break;
                }

                if (trim($robot) == 'Disallow: /') {
                    unset($robots[$key]);
                }
            }

            if ($turnOffRobot) {
                array_splice($robots, 1, 0, 'Disallow:' . PHP_EOL);
                $this->lib_admin->log(lang("Robots was opened - ", "admin") . $this->input->ip_address());
            }
        }

        return file_put_contents('robots.txt', $robots);
    }

    /**
     * Getting values of "siteinfo" from POST
     * Uploads logo and favicon (if present)
     * @return boolean whatever data was saved or not
     */
    protected function processSiteInfo() {

        $this->load->library('SiteInfo', $_POST['siteinfo_locale']);
        unset($_POST['siteinfo_locale']);

        // getting all parameters with keys
        $siteinfo = array();
        foreach ($_POST as $key => $value) {
            if (0 === strpos($key, "siteinfo_")) {
                $siteinfo[$key] = $value;
                unset($_POST[$key]);
            }
        }

        // remap additional fields
        $additional = array();
        $countKeys = count($siteinfo['siteinfo_contactkey']);
        $countValues = count($siteinfo['siteinfo_contactvalue']);
        if ($countKeys == $countValues & $countValues > 0) {
            for ($i = 0; $i < $countKeys; $i++) {
                if (!empty($siteinfo['siteinfo_contactkey'][$i])) {
                    $additional[$siteinfo['siteinfo_contactkey'][$i]] = $siteinfo['siteinfo_contactvalue'][$i];
                    //$siteinfo["siteinfo_" . $siteinfo['siteinfo_contactkey'][$i]] = $siteinfo['siteinfo_contactvalue'][$i];
                }
            }
        }

        unset($siteinfo['siteinfo_contactkey']);
        unset($siteinfo['siteinfo_contactvalue']);

        $siteinfo['contacts'] = $additional;

        $upload_path = rtrim(FCPATH, '/') . $this->siteinfo->imagesPath;

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|ico|gif';
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);



        // upload or delete (or do nothing) favicon and logo
        if ($_POST['si_delete_favicon'] == 1) {
            if (isset($siteinfo['siteinfo_favicon'])) {
                unset($siteinfo['siteinfo_favicon']);
            }
        } else {
            $this->processLogoOrFavicon('siteinfo_favicon', $siteinfo);
        }

        if ($_POST['si_delete_logo'] == 1) {
            if (isset($siteinfo['siteinfo_logo'])) {
                unset($siteinfo['siteinfo_logo']);
            }
        } else {
            $this->processLogoOrFavicon('siteinfo_logo', $siteinfo);
        }

        // saving admin's email in application/config/auth.php
        $authFullPath = "./application/config/auth.php";
        $authContents = file_get_contents($authFullPath);
        $pattern = '/(\$config\[\'DX_webmaster_email\'\][\s\=]{1,})[\'\"0-9A-Za-z\@\.\-\_]+/i';
        $replacement = '$1\'' . $siteinfo['siteinfo_adminemail'] . '\'';
        $newAuthContents = preg_replace($pattern, $replacement, $authContents);
        if (is_writable($authFullPath)) {
            $this->load->helper('file');
            write_file($authFullPath, $newAuthContents);
        }

        $this->siteinfo->setSiteInfoData($siteinfo);
        if ($_POST['si_delete_favicon'] == 1) {
            $this->siteinfo->deleteSiteInfoValue('favicon');
        }
        if ($_POST['si_delete_logo'] == 1) {
            $this->siteinfo->deleteSiteInfoValue('logo');
        }
        return $this->siteinfo->save();
    }

    public function getSiteInfoDataJson() {
        $this->load->library('SiteInfo', $_POST['locale']);
        $data = $this->siteinfo->getSiteInfoData(TRUE);
        echo json_encode(array_merge($data, array('locale' => $_POST['locale'])));
    }

    /**
     *
     * @param type $paramName
     * @param type $siteinfo
     */
    protected function processLogoOrFavicon($paramName, &$siteinfo) {
        // setting old value
        $oldValue = $this->siteinfo->getSiteInfo($paramName);
        $siteinfo[$paramName] = !empty($oldValue) ? $oldValue : '';
        if (isset($_FILES[$paramName])) {
            if (!$this->upload->do_upload($paramName)) {
                echo $this->upload->display_errors('', '');
            } else {
                $uploadData = $this->upload->data();
                $siteinfo[$paramName] = $uploadData['file_name'];
            }
        }
    }

    public function switch_admin_lang($lang) {
        if ($lang) {
            $this->db->set('lang_sel', $lang)
                    ->update('settings');
            $this->session->set_userdata('language', $lang);
        }
        redirect($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/admin/dashboard');
    }

    /**
     * Returns license agreement from template, or default agreement
     * @return string
     */
    public function license_agreement() {
        header('Content-Type: text/plain; charset=utf-8');
        $template = new \template_manager\classes\Template($_GET['template_name']);
        echo $template->getLicenseAgreement();
    }

    public function template_has_license($templateName = null) {
        if (is_null($templateName)) {
            $templateName = $_GET['template_name'];
        }

        if (empty($templateName)) {
            echo 0;
            return;
        }
        if (false == class_exists('\\template_manager\\classes\\Template')) {
            echo 0;
            return;
        }
        $template = new \template_manager\classes\Template($templateName);
        $license = $template->getLicenseAgreement();
        echo empty($license) ? 0 : 1;
    }

}

/* End of settings.php */

