<?php

/**
 * AccountResetPassword is the data structure for keeping account password form data.
 * It is used by the 'resetPassword' action of 'AccountUserController'.
 *
 * @property AccountUser $user
 * @property AccountUserIdentity $userIdentity
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountResetPassword extends CFormModel
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
     * @var int
     */
    public $user_id;

    /**
     * @var string
     */
    public $token;

    /**
     * @var AccountUser
     */
    private $_user;

    /**
     * @var AccountUserIdentity
     */
    private $_userIdentity;

    /**
     * Declares the validation rules.
     * @return array
     */
    public function rules()
    {
        return array(
            array('new_password, confirm_password', 'required'),
            array('new_password', 'length', 'min' => 5),
            array('confirm_password', 'compare', 'compareAttribute' => 'new_password'),
        );
    }

    /**
     * @param int $user_id
     * @param string $token
     * @return bool
     */
    public function checkToken($user_id, $token)
    {
        $this->user_id = $user_id;
        $this->token = $token;
        if (!$this->user)
            return false;
        return Yii::app()->tokenManager->checkToken('AccountLostPassword', $user_id, $token);
    }

    /**
     * Updates the users password.
     */
    public function save()
    {
        if (!$this->validate())
            return false;

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');

        $this->user->{$account->passwordField} = CPasswordHelper::hashPassword($this->new_password);
        if (!$this->user->save(false))
            return false;

        if (!$this->userIdentity->authenticate() || !Yii::app()->user->login($this->userIdentity))
            return false;

        Yii::app()->tokenManager->useToken('AccountLostPassword', $this->user_id, $this->token);
        return true;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
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
            $this->_user = CActiveRecord::model($account->userClass)->findByPk($this->user_id);
        }
        return $this->_user;
    }

    /**
     * @return UserIdentity
     */
    public function getUserIdentity()
    {
        if (!$this->_userIdentity) {
            /** @var AccountModule $account */
            $account = Yii::app()->getModule('account');
            $this->_userIdentity = new $account->userIdentityClass($this->user->{$account->emailField}, $this->new_password);
        }
        return $this->_userIdentity;
    }

} 
