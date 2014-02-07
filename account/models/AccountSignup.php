<?php

/**
 * AccountSignUp is the data structure for keeping account registration form data.
 * It is used by the 'signUp' action of 'AccountUserController'.
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
    public $userClass = 'AccountUser';

    /**
     * @var string
     */
    public $firstNameField = 'first_name';

    /**
     * @var string
     */
    public $lastNameField = 'last_name';

    /**
     * @var string
     */
    public $emailField = 'email';

    /**
     * @var string
     */
    public $usernameField = 'username';

    /**
     * @var string
     */
    public $passwordField = 'password';

    /**
     * @var string
     */
    public $statusField = 'status';

    /**
     * @var int
     */
    public $defaultStatus = 1;

    /**
     * @var string
     */
    public $userIdentityClass = 'UserIdentity';

    /**
     * @var AccountUser
     */
    private $_user;

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
        return array(
            array('email, username, first_name, password, confirm_password', 'required'),
            array('email, username', 'length', 'max' => 255),
            array('first_name, last_name', 'length', 'max' => 32),
            array('email', 'email'),
            array('email, username', 'unique', 'className' => $this->userClass),
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
        );
    }

    /**
     * Creates the user.
     * @return bool
     */
    public function save()
    {
        if (!$this->validate())
            return false;

        // create user
        $this->user->{$this->emailField} = $this->email;
        $this->user->{$this->passwordField} = CPasswordHelper::hashPassword($this->password);
        $this->user->{$this->statusField} = $this->defaultStatus;
        if ($this->firstNameField)
            $this->user->{$this->firstNameField} = $this->first_name;
        if ($this->lastNameField)
            $this->user->{$this->lastNameField} = $this->last_name;
        if ($this->usernameField)
            $this->user->{$this->usernameField} = $this->username;
        if (!$this->user->save(false))
            return false;

        // login
        if ($this->defaultStatus && $this->userIdentity->authenticate())
            return Yii::app()->user->login($this->userIdentity);
        else
            return true;
    }

    /**
     * @return AccountUser
     */
    public function getUser()
    {
        if (!$this->_user)
            $this->_user = new $this->userClass();
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
