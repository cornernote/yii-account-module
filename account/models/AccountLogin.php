<?php

/**
 * AccountLogin is the data structure for keeping account login form data.
 * It is used by the 'login' action of 'AccountController'.
 *
 * @property UserIdentity $userIdentity
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
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
     * @var int
     */
    public $rememberDuration = 2592000; // 30 days

    /**
     * @var string
     */
    public $userIdentityClass = 'UserIdentity';

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
        $rules = array(
            array('username, password', 'required'),
            array('username', 'authenticate', 'skipOnError' => true),
            array('remember', 'boolean'),
        );
        //// recaptcha
        //if (isset(Yii::app()->reCaptcha)) {
        //    $rules[] = array('recaptcha', 'account.validators.AccountReCaptchaValidator', 'on' => 'recaptcha');
        //}
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
            //'recaptcha' => Yii::t('account', 'Enter both words separated by a space'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     * @param $attribute
     * @param $params
     */
    public function authenticate($attribute, $params)
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
        // TODO - enable recaptcha
        //// recaptcha after 3 attempts
        //$attemptKey = "login.attempt.{$_SERVER['REMOTE_ADDR']}";
        //$attempts = Yii::app()->cache->get($attemptKey);
        //if (!$attempts)
        //    $attempts = 0;
        //$scenario = ($attempts > 3 && isset(Yii::app()->reCaptcha)) ? 'recaptcha' : '';

        if (!$this->validate())
            return false;
        if (!$this->userIdentity->authenticate())
            return false;

        if (Yii::app()->user->login($this->userIdentity, $this->remember ? $this->rememberDuration : 0)) {
            //Yii::app()->cache->delete($attemptKey);
            return true;
        }

        // remove all other errors on recaptcha error
        //if (isset($accountLogin->errors['recaptcha'])) {
        //    $errors = $accountLogin->errors['recaptcha'];
        //    $accountLogin->clearErrors();
        //    foreach ($errors as $error)
        //        $accountLogin->addError('recaptcha', $error);
        //}
        //Yii::app()->cache->set($attemptKey, ++$attempts);

        return false;
    }


    /**
     * @return UserIdentity
     */
    public function getUserIdentity()
    {
        if (!$this->_userIdentity)
            $this->_userIdentity = new $this->userIdentityClass($this->username, $this->password);
        return $this->_userIdentity;
    }

}
