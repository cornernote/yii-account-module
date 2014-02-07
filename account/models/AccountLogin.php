<?php

/**
 * AccountLogin is the data structure for keeping account login form data.
 * It is used by the 'login' action of 'AccountUserController'.
 *
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
     * @var UserIdentity
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
        $rules = array(
            array('username, password', 'required'),
            array('username', 'authenticate', 'skipOnError' => true),
            array('remember', 'boolean'),
        );
        if ($account->reCaptcha && $this->scenario == 'captcha') {
            $rules[] = array('captcha', 'account.validators.AccountReCaptchaValidator');
        }
        return $rules;
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
     * Logs in the user.
     * @return boolean whether login is successful
     */
    public function login()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');

        // captcha after 3 attempts
        $attemptKey = 'AccountLogin.attempt.' . Yii::app()->request->userHostAddress;
        $attempts = Yii::app()->cache->get($attemptKey) || 0;
        $this->scenario = ($account->reCaptcha && $attempts > 3) ? 'captcha' : '';

        if (!$this->validate())
            return false;
        if (!$this->userIdentity->authenticate())
            return false;

        if (Yii::app()->user->login($this->userIdentity, $this->remember ? $account->rememberDuration : 0)) {
            Yii::app()->cache->delete($attemptKey);
            return true;
        }

        // remove all other errors on captcha error
        if ($errors = $this->getErrors('captcha')) {
            $this->clearErrors();
            foreach ($errors as $error)
                $this->addError('captcha', $error);
        }
        Yii::app()->cache->set($attemptKey, ++$attempts);

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