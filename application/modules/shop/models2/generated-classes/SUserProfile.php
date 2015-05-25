<?php 

 use Base\SUserProfile as BaseSUserProfile;
 use Propel\Runtime\Connection\ConnectionInterface;

/**
 * Skeleton subclass for representing a row from the 'shop_user_profile' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SUserProfile extends BaseSUserProfile {

    public $entityName = 'user';

    public function attributeLabels() {
        return array(
            'UserId' => ShopCore::t('ID'),
            'Login' => ShopCore::t(lang('Login', 'admin')),
            'Password' => ShopCore::t(lang('Password', 'admin')),
            'UserEmail' => ShopCore::t(lang('Email', 'admin')),
            'Role' => ShopCore::t(lang('Group', 'admin')),
            'Name' => ShopCore::t(lang('FIO', 'admin')),
            'Phone' => ShopCore::t(lang('Phone', 'admin')),
            'Address' => ShopCore::t(lang('Address', 'admin')),
            'DateCreated' => ShopCore::t(lang('Time register', 'admin')),
            'AmountPurchases' => ShopCore::t(lang('Sum purchases', 'admin')),
            'Role' => ShopCore::t(lang('Role', 'admin')),
        );
    }

    public function rules($action) {
        switch ($action) {
            case 'create':
                return array(
                    array(
                        'field' => 'Password',
                        'label' => $this->getLabel('Password'),
                        'rules' => 'trim|required|xss_clean',
                    ),
                    array(
                        'field' => 'Name',
                        'label' => $this->getLabel('Name'),
                        'rules' => 'required',
                    ),
                    array(
                        'field' => 'Phone',
                        'label' => $this->getLabel('Phone'),
                        //'rules' => 'numeric',
                        'rules' => 'trim|callback_check_phone',
                    ),
                    array(
                        'field' => 'UserEmail',
                        'label' => $this->getLabel('UserEmail'),
                        'rules' => 'trim|required|xss_clean|valid_email',
                    ),
                );
            case 'edit':
                return array(
                    array(
                        'field' => 'Name',
                        'label' => $this->getLabel('Name'),
                        'rules' => 'required',
                    ),
                    array(
                        'field' => 'Phone',
                        'label' => $this->getLabel('Phone'),
                        //'rules' => 'numeric',
                        'rules' => 'trim|callback_check_phone',
                    ),
                    array(
                        'field' => 'UserEmail',
                        'label' => $this->getLabel('UserEmail'),
                        'rules' => 'trim|required|xss_clean|valid_email',
                    ),
                );
        }
    }

    public function getFullName() {
        return $this->getName();
    }

    public function postSave(ConnectionInterface $con = null) {
        if ($this->hasCustomData === false)
            $this->collectCustomData($this->entityName, $this->getId());
        $this->saveCustomData();
//        $this->saveCustomData();
//        return $this;
//        if (is_numeric($this->getId()) )
        //saving custom data
        //TODO: need recode to use $this->saveCustomData()
//            ShopCore::app()->CustomFieldsDataQuery->saveCustomFieldsData($this->getId());
//        parent::preSave();
        return $this;
    }

    public function getUserId() {
        return $this->getId();
    }

}

// SUserProfile
