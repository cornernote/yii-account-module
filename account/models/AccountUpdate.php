<?php

/**
 * AccountPassword is the data structure for keeping account password form data.
 * It is used by the 'password' action of 'AccountController'.
 *
 * @property AccountUser $user
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountUpdate extends CFormModel
{

    /**
     * @var string
     */
    public $email;

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
    public $username;

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
     * @var AccountUser
     */
    public $_user;

    /**
     * Declares the validation rules.
     * @return array
     */
    public function rules()
    {
        return array(
            array('email, username, first_name', 'required'),
            array('email, username', 'length', 'max' => 255),
            array('first_name, last_name', 'length', 'max' => 32),
            array('email', 'email'),
            array('email, username', 'unique', 'className' => $this->userClass),
        );
    }

    /**
     * Updates the users account.
     */
    public function save()
    {
        if (!$this->validate())
            return false;

        $this->user->{$this->emailField} = $this->email;
        if ($this->firstNameField)
            $this->user->{$this->firstNameField} = $this->first_name;
        if ($this->lastNameField)
            $this->user->{$this->lastNameField} = $this->last_name;
        if ($this->usernameField)
            $this->user->{$this->usernameField} = $this->username;
        return $this->user->save(false);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'email' => Yii::t('account', 'Email'),
            'first_name' => Yii::t('account', 'First Name'),
            'last_name' => Yii::t('account', 'Last Name'),
            'username' => Yii::t('account', 'Username'),
        );
    }

    /**
     * @return AccountUser
     */
    public function getUser()
    {
        if (!$this->_user)
            $this->_user = CActiveRecord::model($this->userClass)->findByPk(Yii::app()->user->id);
        return $this->_user;
    }

} 
