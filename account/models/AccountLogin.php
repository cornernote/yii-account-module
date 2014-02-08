<?php

/**
 * AccountLogin is the data structure for keeping account login form data.
 * It is used by the 'login' action of 'AccountUserController'.
 *
 * @property AccountUserIdentity $userIdentity
 * @property int $attemptCount
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
     * @var int
     */
    private $_attemptCount;

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
        if ($account->reCaptcha && $this->isCaptchaRequired()) {
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

        // validate and login
        if ($this->validate() && Yii::app()->user->login($this->userIdentity, $this->remember ? $account->rememberDuration : 0)) {
            $this->attemptCount = 0;
            return true;
        }

        // save the attempt count
        $this->attemptCount++;
        return false;
    }

    /**
     * @return AccountUserIdentity
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

    /**
     * @return string
     */
    private function attemptKey()
    {
        return 'AccountLogin.attempt.' . Yii::app()->request->userHostAddress;
    }

    /**
     * @return int
     */
    public function getAttemptCount()
    {
        if ($this->_attemptCount === null) {
            $this->_attemptCount = Yii::app()->cache->get($this->attemptKey());
            if (!$this->_attemptCount)
                $this->_attemptCount = 0;
        }
        return $this->_attemptCount;
    }

    /**
     * @param int $attemptCount
     */
    public function setAttemptCount($attemptCount)
    {
        if ($attemptCount > 0)
            Yii::app()->cache->set($this->attemptKey(), $attemptCount);
        else
            Yii::app()->cache->delete($this->attemptKey());
        $this->_attemptCount = $attemptCount > 0 ? (int)$attemptCount : 0;
    }

    /**
     * @return bool
     */
    public function isCaptchaRequired()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        return ($account->reCaptcha && $this->attemptCount >= $account->reCaptchaLoginCount);
    }

}