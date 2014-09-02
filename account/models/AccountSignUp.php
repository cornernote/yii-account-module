<?php

/**
 * AccountSignUp is the data structure for keeping account registration form data.
 * It is used by the 'signUp' action of 'AccountUserController'.
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
class AccountSignUp extends CFormModel
{

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $confirm_password;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $timezone;

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
            array('email, username, first_name, password, confirm_password', 'required'),
            array('email, username, timezone', 'length', 'max' => 255),
            array('first_name, last_name', 'length', 'max' => 32),
            array('email', 'email'),
            array('email, username', 'unique', 'className' => $account->userClass),
            array('username', 'match', 'pattern' => '/^[0-9a-z\-_]+$/u', 'message' => Yii::t('account', 'Username can only contain numbers, letters and dash (-) characters')),
            array('password', 'length', 'min' => 5),
            array('confirm_password', 'compare', 'compareAttribute' => 'password'),
        );
    }

    /**
     * Declares attribute labels.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'email' => Yii::t('account', 'Email'),
            'first_name' => Yii::t('account', 'First Name'),
            'last_name' => Yii::t('account', 'Last Name'),
            'username' => Yii::t('account', 'Username'),
            'password' => Yii::t('account', 'Password'),
            'timezone' => Yii::t('account', 'Timezone'),
        );
    }

    /**
     * Creates the user.
     * @return bool
     */
    public function save($runValidation = true)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');

        // create user
        if (!$this->createUser()) {
            return false;
        }
        // return now if activation is required
        if ($account->activatedField && !$account->activatedAfterSignUp) {
            return true;
        }
        // login
        return $this->userIdentity->authenticate() && Yii::app()->user->login($this->userIdentity);
    }

    /**
     * @return bool
     */
    public function createUser()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');

        $this->user->{$account->emailField} = $this->email;
        $this->user->{$account->passwordField} = CPasswordHelper::hashPassword($this->password);
        if ($account->activatedField) {
            $this->user->{$account->activatedField} = $account->activatedAfterSignUp ? 1 : 0;
        }
        if ($account->firstNameField) {
            $this->user->{$account->firstNameField} = $this->first_name;
        }
        if ($account->lastNameField) {
            $this->user->{$account->lastNameField} = $this->last_name;
        }
        if ($account->usernameField) {
            $this->user->{$account->usernameField} = $this->username;
        }
        if ($account->timezoneField) {
            $this->user->{$account->timezoneField} = $this->timezone;
        }
        return $this->user->save(false);
    }

    /**
     * @return AccountUser
     */
    public function getUser()
    {
        if (!$this->_user) {
            /** @var AccountModule $account */
            $account = Yii::app()->getModule('account');
            $this->_user = new $account->userClass();
        }
        return $this->_user;
    }

    /**
     * @return AccountUserIdentity
     */
    public function getUserIdentity()
    {
        if (!$this->_userIdentity) {
            /** @var AccountModule $account */
            $account = Yii::app()->getModule('account');
            $this->_userIdentity = new $account->userIdentityClass($this->email, $this->password);
        }
        return $this->_userIdentity;
    }

}
