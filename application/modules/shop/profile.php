<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * User Profile Controller
 *
 * @uses ShopController
 * @package Shop
 * @version 0.1
 * @copyright 2010 Siteimage
 * @author <dev
 */
class Profile extends \Profile\BaseProfile {

    protected $_userId = null;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display list of user order
     *
     * @access public
     */
    public function index() {
        $this->template->registerMeta("ROBOTS", "NOINDEX, NOFOLLOW");
        if (strstr($this->uri->uri_string(), 'shop/profile/profile_change_pass')) {
            $this->profileChangePass();
        }
        if (strstr($this->uri->uri_string(), 'shop/profile/profile_data')) {
            $this->profileData();
        }
        if (strstr($this->uri->uri_string(), 'shop/profile/profile_history')) {
            $this->profileHistory();
        }
        $this->render($this->data['template'], $this->data);
    }

    public function profileChangePass() {
        $this->render_min('profile_change_pass', $this->data);
        exit;
    }

    public function profileData() {
        $this->render_min('profile_data', $this->data);
        exit;
    }

    public function profileHistory() {
        $this->render_min('profile_history', $this->data);
        exit;
    }

}
/* End of file profile.php */
