<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * WishList Controller
 * 
 * @uses ShopController
 * @package Shop
 * @version 0.1
 * @copyright 2010 Siteimage
 * @author <dev 
 */
class Wish_list extends ShopController {

    public $maxRange = 100; // Max number of products in wish list.

    public function __construct() {
        parent::__construct();
        $this->load->library('Form_validation');
        $this->load->module('core');
        $this->_userId = $this->dx_auth->get_user_id();
        $wish_list_url = $this->uri->segment($this->uri->total_segments());
        if (strlen($wish_list_url) == 5) {
            $this->wishkey = $wish_list_url;
            $this->index();
            exit;
        }
    }

    /**
     * Display WishList page.
     *
     * @access public
     */
    public function index() {
        $this->load->helper('Form');
        $this->core->set_meta_tags(ShopCore::t('Wish List'));        
        $wish['UserId'] = $this->dx_auth->get_user_id();
        if($_POST['friendsMail'])
            $this->sendWishList ($_POST['friendsMail']);
        if ($this->dx_auth->is_logged_in() === true) {
            
            $sUserProfile = SUserProfileQuery::create()->filterById($this->dx_auth->get_user_id())->findOne();
            $profile['name'] = $sUserProfile->getName();
            $profile['phone'] = $sUserProfile->getPhone();
            if ($sUserProfile->getKey() == '') {
                $sUserProfile->setKey(3, 2);
                $sUserProfile->save();
            }
            $profile['key'] = $sUserProfile->getKey();
            $profile['email'] = $sUserProfile->getUserEmail();
            // Count roral price
            $total_price=0;
            foreach (ShopCore::app()->SWishList->loadProducts($this->wishkey) as $key => $item) {
                foreach ($item['model']->getProductVariants() as $variants)
                    if ($variants->getId() == $item[1]){
                        $variant = $variants;
                        break;
                    }
                $total_price =$total_price +$variant->toCurrency();
            }
            
            $this->render('wish_list', array(
                'items' => ShopCore::app()->SWishList->loadProducts($this->wishkey),
                'capImage' => $capImage,
                'profile' => $profile,
                'rkey' => $this->wishkey,
                'total_price' => number_format($total_price, ShopCore::app()->SSettings->pricePrecision, ".", "")
            ));
            
        } else {
            $this->core->error_404();
        }
    }

    /**
     * View WishList data.
     *
     * @param  $userId
     * @param  $wishListSecretKey
     * @return void
     */
    public function view($userId = null, $wishSecretKey = null) {
        if (isset($_REQUEST['Shp_wishList']) && isset($_REQUEST['Shp_userId'])) {
            $wishSecretKey = $_REQUEST['Shp_wishList'];
            $userId = $_REQUEST['Shp_userId'];
        }
        $model = SUserProfileQuery::create()
                ->filterById($userId)
                ->findOne();
        if ($model != null) {
            if ($model->getKey() === $wishSecretKey) {
                $wishListData = unserialize($model->getWishListData());
                if (!is_array($wishListData)) {
                    $this->core->error_404();
                } else {
                    $newData = array();
                    $newCollection = array();
                    $ids = array_map("array_shift", $wishListData);
                    if (sizeof($ids) > 0) {
                        // Load products
                        $collection = SProductsQuery::create()
                                ->findPks(array_unique($ids));
                    }
                    else
                        $this->core->error_404();

                    for ($i = 0; $i < sizeof($collection); $i++) {
                        $newCollection[$collection[$i]->getId()] = $collection[$i];
                    }
                    foreach ($wishListData as $key => $item) {
                        if ($newCollection[$item[0]] !== null) {
                            $item['model'] = $newCollection[$item[0]];
                            $productVariant = SProductVariantsQuery::create()->filterById($item[1])->findOne();
                            $item['variantName'] = $productVariant->getName();
                            $item['price'] = round($productVariant->getPrice(), ShopCore::app()->SSettings->pricePrecision);
                            $newData[$key] = $item;
                        }
                    }
                }
            }
            else
                $this->core->error_404();
        }
        else
            $this->core->error_404();
        $this->load->module('core'); 
        $this->core->set_meta_tags(ShopCore::t('Просмотр WishList\'а'));
        $this->template->registerMeta("ROBOTS", "NOINDEX, NOFOLLOW");
        $this->render('wish_view', array(
            'items' => $newData,
        ));
    }
    /**
     *  Save cookie to profile
     */
    public function move_to_profile() {
        ShopCore::app()->SWishList->unionDbAndCookieWishLists();
        $this->_redirectBack();
    }
    /**
     * 
     */
    public function clear_cookie_wish_list() {
        ShopCore::app()->SWishList->removeWishListCookie();
        $this->_redirectBack();
    }

    /**
     * Add product to WishList from POST data.
     *
     * @access public
     */
    public function add() {
        // Search for product and its variant
        $model = SProductsQuery::create()->findPk((int) $_POST['productId_']);
        if ($model !== null && ShopCore::app()->SWishList->countData() < $this->maxRange) {
            ShopCore::app()->SWishList->add(array(
                'model' => $model,
                'variantId' => (int) $_POST['variantId_'],
            ));
        }
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest')
            $this->_redirectBack();
    }
    /**
     * Remove product from Wishlist
     */
    public function delete() {
        ShopCore::app()->SWishList->removeOne($this->uri->segment($this->uri->total_segments()));
        $this->redirectToWishList();
    }

    /**
     * Create random code.
     *
     * @param int $charsCount
     * @param int $digitsCount
     * @static
     * @access public
     * @return string
     */
    public static function createCode($charsCount = 3, $digitsCount = 7) {
        $chars = array('q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm');
        if ($charsCount > sizeof($chars))
            $charsCount = sizeof($chars);
        $result = array();
        if ($charsCount > 0) {
            $randCharsKeys = array_rand($chars, $charsCount);
            foreach ($randCharsKeys as $key => $val)
                array_push($result, $chars[$val]);
        }
        for ($i = 0; $i < $digitsCount; $i++)
            array_push($result, rand(0, 9));
        shuffle($result);
        $result = implode('', $result);
        if (sizeof(SUserProfileQuery::create()->filterByKey($result)->select(array('Key'))->limit(1)->find()) > 0)
            self::createCode($charsCount, $digitsCount);
        return $result;
    }

    /**
     * Validate user data.
     *
     * @return void
     */
    protected function _validateUserInfo() {
        $this->form_validation->set_rules('userInfo[fullName]', ShopCore::t('Имя, фамилия'), 'required|max_length[50]');
        $this->form_validation->set_rules('userInfo[email]', ShopCore::t('Email'), 'valid_email|required');
        $this->form_validation->set_rules('userInfo[phone]', ShopCore::t('Телефон'), '');
        $this->form_validation->set_rules('userInfo[commentText]', ShopCore::t('Комментарий к заказу'), '');
        $this->form_validation->set_rules('captcha', lang('Captcha'), 'trim|required|xss_clean|callback_captcha_check');

        if ($this->form_validation->run($this) == FALSE)
            return false;
        else
            return true;
    }

    /**
     * Send email to user.
     *
     * @param array $wish
     * @return void
     */
    public function sendWishList($email) {
//        $this->form_validation->set_rules("friendsMail", "Email", "required|valid_email");
//        if ($this->form_validation->run($this) == FALSE)
//            return false;
        $emailTo = $email;//$this->input->post('email');
        if ($emailTo != '' && $emailTo != Null) {
            $this->_sendMail($emailTo);
        } else {
            return false;
        }
    }
    /**
     * 
     * @param type $emailTo
     * @return boolean
     */
    protected function _sendMail($emailTo) {
        if (ShopCore::app()->SSettings->wishListsMessageText == '')
            return;
        $sUserProfile = SUserProfileQuery::create()->filterById($this->_userId)->findOne();
        if (!unserialize($sUserProfile->getWishListData()))
            $this->redirectToWishList();
        $replaceData = array(
            '%userName%' => $sUserProfile->getName(),
            '%userPhone%' => $sUserProfile->getPhone(),
            '%wishKey%' => $sUserProfile->getKey(),
            '%wishLink%' => shop_url('wish_list/view/' . $this->_userId . '/' . $sUserProfile->getKey()),
            '%wishDateCreated%' => date("d-m-Y H:i:s",time()),
        );
        $replaceData = array_map('encode', $replaceData);
        if (ShopCore::app()->SSettings->wishListsMessageText == '')
            return false;
        $settings['fromEmail'] = ShopCore::app()->SSettings->wishListsSenderEmail;
        $settings['fromName'] = ShopCore::app()->SSettings->wishListsSenderName;
        $settings['theme'] = ShopCore::app()->SSettings->wishListsMessageTheme;
        $settings['message'] = str_replace(array_keys($replaceData), $replaceData, ShopCore::app()->SSettings->wishListsMessageText);
        $settings['toEmail'] = $emailTo;

        $this->load->library('email');
        $config['mailtype'] = ShopCore::app()->SSettings->wishListsMessageFormat;
        $this->email->initialize($config);

        $this->email->from($settings['fromEmail'], $settings['fromName']);
        $this->email->to($settings['toEmail']);
        $this->email->subject($settings['theme']);
        $this->email->message($settings['message']);
        $this->email->send();
    }

    protected function _redirectBack() {
        redirect($_SERVER['HTTP_REFERER']);
        exit;
    }

    protected function redirectToWishList() {
        redirect(shop_url('wish_list'));
    }
    
    public function captcha_check($code) {
        if ($this->dx_auth->is_admin() == TRUE)
            return TRUE;
        if (!$this->dx_auth->captcha_check($code))
            return FALSE;
        else
            return TRUE;
    }

}

/* End of file wish_list.php */
