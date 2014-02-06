<?php

/**
 * AccountLogin is the data structure for keeping account login form data.
 * It is used by the 'login' action of 'AccountController'.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package account.models
 */
class AccountLogin extends AccountFormModel
{

    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $rememberMe;

    /**
     * @var int
     */
    public $rememberMeDuration = 2592000; // 30 days

    /**
     * @var
     */
    public $recaptcha;

    /**
     * @var string
     */
    public $userIdentityClass = 'CUserIdentity';

    /**
     * @var CUserIdentity
     */
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that email and password are required,
     * and password needs to be authenticated.
     * @return array
     */
    public function rules()
    {
        $rules = array(
            // email
            array('email', 'required'),

            // password
            array('password', 'required'),
            array('password', 'authenticate', 'skipOnError' => true),

            // rememberMe
            array('rememberMe', 'boolean'),
        );
        // recaptcha
        if (isset(Yii::app()->reCaptcha)) {
            $rules[] = array('recaptcha', 'account.validators.AccountReCaptchaValidator', 'on' => 'recaptcha');
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
            'email' => Yii::t('account', 'Email'),
            'password' => Yii::t('account', 'Password'),
            'rememberMe' => Yii::t('account', 'Remember me next time'),
            'recaptcha' => Yii::t('account', 'Enter both words separated by a space'),
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
        $this->_identity = new $this->userIdentityClass($this->email, $this->password);
        if (!$this->_identity->authenticate()) {
            $this->addError('password', 'Incorrect email or password.');
        }
    }

    /**
     * Logs in the user using the given email and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new $this->userIdentityClass($this->email, $this->password);
        }
        if ($this->_identity->authenticate()) {
            return Yii::app()->user->login($this->_identity, $this->rememberMe ? $this->rememberMeDuration : 0);
        }
        return false;
    }

}
