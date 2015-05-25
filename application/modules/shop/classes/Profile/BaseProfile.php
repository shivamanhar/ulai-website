<?php

namespace Profile;

use Propel\Runtime\ActiveQuery\Criteria;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Shop Controller
 *
 * @uses \ShopController
 * @package Shop
 * @copyright 2013 ImageCMS
 * @property model SProducts
 */
class BaseProfile extends \ShopController {

    public $data = null;
    public $model;
    protected $_userId = null;
    public $templateFile = 'profile';

    public function __construct() {
        parent::__construct();

        if (!$this->dx_auth->is_logged_in())
            redirect('/');

        $this->_userId = $this->dx_auth->get_user_id();

        $this->__CMSCore__();
        $this->index();
        exit;
    }

    /**
     * Display product info.
     *
     * @access public
     */
    public function __CMSCore__() {
        $this->load->helper('Form');

        $this->core->set_meta_tags(lang('Profile'));

        if ($_POST) {
            $errors = $this->_edit();
        }

        $profile = \SUserProfileQuery::create()
                ->filterById($this->_userId)
                ->findOne();

        $user = $this->db
                ->where('id', $this->_userId)
                ->get('users')
                ->row_array();

        $this->data = array(
            'template' => $this->templateFile,
            'orders' => \SOrdersModel::getOrdersByID($this->_userId, Criteria::DESC),
            'profile' => $profile,
            'user' => $user,
            'errors' => $errors
        );
    }

    /**
     * Edit user profile
     * @deprecated since version 4.2
     * @access private
     */
    private function _edit() {
        $profile = \SUserProfileQuery::create()->filterById($this->_userId)->findOne();
        $user = $this->db->where('id', $this->_userId)->get('users')->row_array();
        $errors = '';

        $this->load->library('form_validation');

        if ($this->input->post('changeName')) {

            $this->form_validation->set_rules('name', '<b>' . lang('Name') . '</b>', 'trim|required|xss_clean|min_length[4]');
            $this->form_validation->set_rules('email', '<b>' . lang('Email') . '</b>', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('address', '<b>' . lang('Address') . '</b>', 'trim|xss_clean');
            $this->form_validation->set_rules('phone', '<b>' . lang('Phone') . '</b>', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $errors = validation_errors();
            } else {
                $profile->setName($this->input->post('name'));
                $profile->setUserEmail($this->input->post('email'));
                $profile->setAddress($this->input->post('address'));
                $profile->setPhone($this->input->post('phone'));

                $profile->save();

                $this->db->where('id', $this->_userId);
                $this->db->update('users', array('email' => $this->input->post('email')));

                $errors .= lang('Data is saved');
            }
            return $errors;
        }
        if ($this->input->post('cangePassword')) {

            $this->form_validation->set_rules('old_password', '<b>' . lang('Old password') . '</b>', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', '<b>' . lang('Password') . '</b>', 'trim|required|xss_clean|matches[confirm_new_password]|max_length[12]');
            $this->form_validation->set_rules('confirm_new_password', '<b>' . lang('Confirm password') . '</b>', 'trim|required|xss_clean |max_length[12]');

            if ($this->form_validation->run() == FALSE) {
                $errors = validation_errors();
            } else {
                if (!$this->dx_auth->change_password($this->input->post('Old password'), $this->input->post('password'))) {
                    $errors = '<b>' . lang('Password') . '</b>' . lang('wrong');
                } else {
                    $errors = '<b>' . lang('Password') . '</b>' . lang('successfully saved.');
                }
            }
        }
        return $errors;
    }

}

/* End of file product.php _Admin_ ImageCms */