<?php

/**
 * AccountUpdate is the data structure for keeping account form data.
 * It is used by the 'update' action of 'AccountUserController'.
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
    public $timezone;

    /**
     * @var string
     */
    public $current_password;

    /**
     * @var AccountUser
     */
    private $_user;

    /**
     * Declares the validation rules.
     * @return array
     */
    public function rules()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        return array(
            array('current_password, email, username, first_name', 'required'),
            array('current_password', 'validateCurrentPassword'),
            array('email, username, timezone', 'length', 'max' => 255),
            array('first_name, last_name', 'length', 'max' => 32),
            array('email', 'email'),
            array('email, username', 'unique', 'className' => $account->userClass, 'criteria' => array(
                'condition' => $this->user->tableSchema->primaryKey . '!=' . $this->user->primaryKey
            )),
        );
    }

    /**
     * Validates the users current password.
     * This is the 'validateCurrentPassword' validator as declared in rules().
     * @param $attribute
     */
    public function validateCurrentPassword($attribute)
    {
        if (!$this->user || !CPasswordHelper::verifyPassword($this->current_password, $this->user->password))
            $this->addError($attribute, Yii::t('account', 'Incorrect password.'));
    }

    /**
     * Updates the users account.
     */
    public function save($runValidation = true)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $this->user->{$account->emailField} = $this->email;
        if ($account->firstNameField)
            $this->user->{$account->firstNameField} = $this->first_name;
        if ($account->lastNameField)
            $this->user->{$account->lastNameField} = $this->last_name;
        if ($account->usernameField)
            $this->user->{$account->usernameField} = $this->username;
        if ($account->timezoneField)
            $this->user->{$account->timezoneField} = $this->timezone;
        return $this->user->save(false);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'current_password' => Yii::t('account', 'Current Password'),
            'email' => Yii::t('account', 'Email'),
            'first_name' => Yii::t('account', 'First Name'),
            'last_name' => Yii::t('account', 'Last Name'),
            'username' => Yii::t('account', 'Username'),
            'timezone' => Yii::t('account', 'Timezone'),
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
