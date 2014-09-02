<?php

/**
 * AccountChangePassword is the data structure for keeping account password form data.
 * It is used by the 'changePassword' action of 'AccountUserController'.
 *
 * @property AccountUser $user
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountChangePassword extends CFormModel
{

    /**
     * @var string
     */
    public $new_password;

    /**
     * @var string
     */
    public $confirm_password;

    /**
     * @var string
     */
    public $current_password;

    /**
     * @var AccountUser
     */
    private $_user;

    /**
     * Declares the validation rules.
     * @return array
     */
    public function rules()
    {
        return array(
            array('current_password, new_password, confirm_password', 'required'),
            array('current_password', 'validateCurrentPassword'),
            array('new_password', 'length', 'min' => 5),
            array('confirm_password', 'compare', 'compareAttribute' => 'new_password'),
        );
    }

    /**
     * Validates the users current password.
     * This is the 'validateCurrentPassword' validator as declared in rules().
     * @param $attribute
     */
    public function validateCurrentPassword($attribute)
    {
        if (!$this->user || !CPasswordHelper::verifyPassword($this->current_password, $this->user->password))
            $this->addError($attribute, Yii::t('account', 'Incorrect password.'));
    }

    /**
     * Updates the users password.
     */
    public function save($runValidation = true)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $this->user->{$account->passwordField} = CPasswordHelper::hashPassword($this->new_password);
        return $this->user->save(false);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'current_password' => Yii::t('account', 'Current Password'),
            'new_password' => Yii::t('account', 'New Password'),
            'confirm_password' => Yii::t('account', 'Confirm Password'),
        );
    }

    /**
     * @return AccountUser
     */
    public function getUser()
    {
        if (!$this->_user) {
            /** @var AccountModule $account */
            $account = Yii::app()->getModule('account');
            $this->_user = CActiveRecord::model($account->userClass)->findByPk(Yii::app()->user->id);
        }
        return $this->_user;
    }

} 
