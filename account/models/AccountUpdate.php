<?php

/**
 * AccountPassword is the data structure for keeping account password form data.
 * It is used by the 'password' action of 'AccountUserController'.
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
     * @var AccountUser
     */
    public $_user;

    /**
     * Declares the validation rules.
     * @return array
     */
    public function rules()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        return array(
            array('email, username, first_name', 'required'),
            array('email, username', 'length', 'max' => 255),
            array('first_name, last_name', 'length', 'max' => 32),
            array('email', 'email'),
            array('email, username', 'unique', 'className' => $account->userClass),
        );
    }

    /**
     * Updates the users account.
     */
    public function save()
    {
        if (!$this->validate())
            return false;

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $this->user->{$account->emailField} = $this->email;
        if ($account->firstNameField)
            $this->user->{$account->firstNameField} = $this->first_name;
        if ($account->lastNameField)
            $this->user->{$account->lastNameField} = $this->last_name;
        if ($account->usernameField)
            $this->user->{$account->usernameField} = $this->username;
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
        if (!$this->_user) {
            /** @var AccountModule $account */
            $account = Yii::app()->getModule('account');
            $this->_user = CActiveRecord::model($account->userClass)->findByPk(Yii::app()->user->id);
        }
        return $this->_user;
    }

} 
