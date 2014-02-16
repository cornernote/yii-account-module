<?php

/**
 * AccountResendActivation is the data structure for keeping resend account activation form data.
 * It is used by the 'resendActivation' action of 'AccountUserController'.
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
class AccountResendActivation extends CFormModel
{

    /**
     * @var string
     */
    public $email_or_username;

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
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        return array(
            array('email_or_username', 'required'),
            array('email_or_username', 'checkExists'),
        );
    }

    /**
     * Checks if the user exists.
     * This is the 'validateCurrentPassword' validator as declared in rules().
     * @param $attribute
     */
    public function checkExists($attribute)
    {
        if (!$this->user)
            $this->addError($attribute, strpos($this->$attribute, '@') ? Yii::t('account', 'Email is incorrect.') : Yii::t('account', 'Username is incorrect.'));
    }

    /**
     * Declares attribute labels.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'email_or_username' => Yii::t('account', 'Username or Email'),
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
            $this->_user = CActiveRecord::model($account->userClass)->findByAttributes(array(
                strpos($this->email_or_username, '@') || !$account->usernameField ? $account->emailField : $account->usernameField => $this->email_or_username,
            ));
        }
        return $this->_user;
    }

}
