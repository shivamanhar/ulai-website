<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Shop Controller
 *
 * @uses ShopController
 * @package Shop
 * @version 0.1
 * @copyright 2010 Siteimage
 * @author <dev
 */
class Shop extends ShopController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Save user callback
     *
     * @return void
     */
    public function callback() {
        $success = FALSE;
        $this->load->library('Form_validation');
        $model = new SCallbacks;
        if (!empty($_POST)) {
            $this->form_validation->set_rules($model->rules());

            if ($this->form_validation->run($this) !== FALSE) {
                $model->setThemeId(SCallbackThemesQuery::create()->orderByPosition()->findOne()->getId());
                $model->fromArray($_POST);
                $model->setDate(time());
                $model->setStatusId(SCallbackStatusesQuery::create()->filterByIsDefault(TRUE)->findOne()->getId());
                $model->save();

//                if (ShopSettingsQuery::create()->filterByName('callbacksSendNotification')->findOne()->getValue() == TRUE) {
                $info = array();
                $info['userName'] = $model->getName();
                $info['userPhone'] = $model->getPhone();
                $info['dateCreated'] = $model->getDate();
                $info['callbackStatus'] = $model->getSCallbackStatuses()->getText();
                $info['callbackTheme'] = $model->getSCallbackThemes()->getText();
                $info['userComment'] = $model->getComment();
                $this->_sendMail($info);
//                }
                $locale = \MY_Controller::getCurrentLocale();
                $notif = $this->db->where('locale', $locale)->where('name', 'callback')->get('answer_notifications')->row();
                $success = $notif->message;
            }
        }
        $this->render_min('callback', array('success' => $success));
    }

    public function callbackApi() {
        $success = FALSE;
        $this->load->library('Form_validation');
        $this->form_validation->set_error_delimiters(FALSE, FALSE);
        $model = new SCallbacks;
        if (!empty($_POST)) {

            $this->form_validation->set_message('required', $model->validationMessage('required'));


            $this->form_validation->set_rules($model->rules());

            if ($this->form_validation->run($this) !== FALSE) {
                $theme = SCallbackThemesQuery::create()->orderByPosition()->findOne();
                if ($theme) {
                    $model->setThemeId($theme->getId());
                } else {
                    $model->setThemeId(0);
                }
                $model->fromArray($_POST);
                $model->setDate(time());
                $model->setStatusId(SCallbackStatusesQuery::create()->filterByIsDefault(TRUE)->findOne()->getId());
                $model->save();

//                if (ShopSettingsQuery::create()->filterByName('callbacksSendNotification')->findOne()->getValue() == TRUE) {
                $info = array();
                $info['userName'] = $model->getName();
                $info['userPhone'] = $model->getPhone();
                $info['dateCreated'] = $model->getDate();
                $info['callbackStatus'] = $model->getSCallbackStatuses()->getText();

                if ($theme) {
                    $info['callbackTheme'] = $model->getSCallbackThemes()->getText();
                }

                $info['userComment'] = $model->getComment();
                $this->_sendMail($info);
//                }


                $locale = \MY_Controller::getCurrentLocale();
                $notif = $this->db->where('locale', $locale)->where('name', 'callback')->get('answer_notifications')->row();
                $success = $notif->message;
                echo json_encode(array(
                    'msg' => $success,
                    'status' => true,
                    'close' => true,
                    'refresh' => $this->input->post('refresh') ? $this->input->post('refresh') : FALSE,
                    'redirect' => $this->input->post('redirect') ? $this->input->post('redirect') : FALSE
                ));
            } else {
                echo json_encode(array(
                    'msg' => validation_errors(),
                    'status' => false,
                    'validations' => array(
                        'Name' => form_error('Name'),
                        'Phone' => form_error('Phone'),
                        'Comment' => form_error('Comment')))
                );
            }
        } else {
            echo json_encode(array(
                'msg' => "Ошибка, не достаточно данных",
                'status' => false
            ));
        }
    }

    public function callbackBottom() {
        $success = FALSE;
        $this->load->library('Form_validation');
        $model = new SCallbacks;
        if (!empty($_POST)) {
            $this->form_validation->set_rules($model->rules());

            if ($this->form_validation->run($this) !== FALSE) {
                $model->setThemeId(SCallbackThemesQuery::create()->orderByPosition()->findOne()->getId());
                $model->fromArray($_POST);
                $model->setDate(time());
                $model->setStatusId(SCallbackStatusesQuery::create()->filterByIsDefault(TRUE)->findOne()->getId());
                $model->save();

//                if (ShopSettingsQuery::create()->filterByName('callbacksSendNotification')->findOne()->getValue() == TRUE) {
                $info = array();
                $info['userName'] = $model->getName();
                $info['userPhone'] = $model->getPhone();
                $info['dateCreated'] = $model->getDate();
                $info['callbackStatus'] = $model->getSCallbackStatuses()->getText();
                $info['callbackTheme'] = $model->getSCallbackThemes()->getText();
                $info['userComment'] = $model->getComment();
                $this->_sendMail($info);
//                }
                $success = ShopSettingsQuery::create()->filterByName('adminMessageCallback')->findOne()->getValue();
            }
        }
        $this->render_min('callbackBottom', array('success' => $success));
    }

    /**
     * Send new callback email notification to admin.
     *
     * @param array $callback_info
     * @return void
     */
    protected function _sendMail($info) {

        $callback_variables = array(
            'callbackStatus' => $info['callbackStatus'],
            'callbackTheme' => $info['callbackTheme'] ? $info['callbackTheme'] : '',
            'userName' => $info['userName'],
            'userPhone' => $info['userPhone'],
            'dateCreated' => date("d-m-Y H:i:s", $info['dateCreated']),
            'userComment' => $info['userComment']
        );
        return \cmsemail\email::getInstance()->sendEmail($this->dx_auth->get_user_email(), 'callback', $callback_variables);
    }

    /**
     * Display shop main page
     */
    public function index() {
        if ($this->uri->uri_string() === 'shop')
            redirect('/', 'location', 301);

        $this->core->set_meta_tags();

        $this->render('start_page');
    }

    private function get_pages1() {
        $file = 'dasdas';
    }

}

/* End of file shop.php */
