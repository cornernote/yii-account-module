<?php

/**
 * AccountResetPassword is the data structure for keeping account password form data.
 * It is used by the 'resetPassword' action of 'AccountController'.
 *
 * @property AccountUser $user
 * @property UserIdentity $userIdentity
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
    public $userClass = 'AccountUser';

    /**
     * @var string
     */
    public $passwordField = 'password';

    /**
     * @var string
     */
    public $userIdentityClass = 'UserIdentity';

    /**
     * @var AccountUser
     */
    public $_user;

    /**
     * @var UserIdentity
     */
    public $_userIdentity;

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
     */
    public function checkToken($user_id, $token)
    {
        $this->user_id = $user_id;
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

        $this->user->{$this->passwordField} = CPasswordHelper::hashPassword($this->password);
        if (!$this->user->save(false))
            return false;

        if (!$this->userIdentity->authenticate() || !Yii::app()->user->login($identity))
            return false;

        Yii::app()->tokenManager->useToken('AccountLostPassword', $this->user_id, $token);
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
        if (!$this->_user)
            $this->_user = CActiveRecord::model($this->userClass)->findByPk($this->user_id);
        return $this->_user;
    }

    /**
     * @return UserIdentity
     */
    public function getUserIdentity()
    {
        if (!$this->_userIdentity)
            $this->_userIdentity = new $this->userIdentityClass($this->username ? $this->username : $this->email, $this->password);
        return $this->_userIdentity;
    }

} 
