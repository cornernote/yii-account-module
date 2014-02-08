<?php

/**
 * AccountLogin is the data structure for keeping account login form data.
 * It is used by the 'login' action of 'AccountUserController'.
 *
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
class AccountLogin extends CFormModel
{

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $remember;

    /**
     * @var
     */
    public $captcha;

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
            array('username, password', 'required'),
            array('username', 'authenticate', 'skipOnError' => true),
            array('remember', 'boolean'),
            array('captcha', 'type', 'type' => 'string'),
        );
    }

    /**
     * Declares attribute labels.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'username' => Yii::t('account', 'Username'),
            'password' => Yii::t('account', 'Password'),
            'remember' => Yii::t('account', 'Remember me next time'),
            'captcha' => Yii::t('account', 'Enter both words separated by a space'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     * @param $attribute
     */
    public function authenticate($attribute)
    {
        if (!$this->userIdentity->authenticate())
            $this->addError($attribute, Yii::t('account', 'Incorrect username or password.'));
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        if ($account->reCaptcha && $this->scenario == 'captcha') {
            Yii::import('account.components.AccountReCaptchaValidator');
            $validator = new AccountReCaptchaValidator;
            $validator->attributes = array('captcha');
            $validator->validate($this);
            if ($this->hasErrors('captcha'))
                return false;
        }
        return parent::beforeValidate();
    }

    /**
     * Logs in the user.
     * @return boolean whether login is successful
     */
    public function login()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');

        // captcha after 3 attempts
        $attemptKey = 'AccountLogin.attempt.' . Yii::app()->request->userHostAddress;
        $attempts = Yii::app()->cache->get($attemptKey) + 1;
        $this->scenario = ($account->reCaptcha && $attempts >= 3) ? 'captcha' : '';

        // validate and login
        if ($this->validate() && Yii::app()->user->login($this->userIdentity, $this->remember ? $account->rememberDuration : 0)) {
            Yii::app()->cache->delete($attemptKey);
            return true;
        }

        // save the attempt count
        Yii::app()->cache->set($attemptKey, $attempts);
        return false;
    }


    /**
     * @return UserIdentity
     */
    public function getUserIdentity()
    {
        if (!$this->_userIdentity) {
            /** @var AccountModule $account */
            $account = Yii::app()->getModule('account');
            $this->_userIdentity = new $account->userIdentityClass($this->username, $this->password);
        }
        return $this->_userIdentity;
    }

}