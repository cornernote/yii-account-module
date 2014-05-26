<?php

/**
 * AccountUserIdentity
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountUserIdentity extends CUserIdentity
{
    /**
     * Error - Not Activated
     */
    const ERROR_NOT_ACTIVATED = 3;

    /**
     * Error - Disabled
     */
    const ERROR_DISABLED = 4;

    /**
     * @var bool
     */
    public $skipPassword = false;

    /**
     * @var int
     */
    private $_id;

    /**
     * Authentication
     * @return bool
     */
    public function authenticate()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        /** @var AccountUser $user */
        $user = CActiveRecord::model($account->userClass)->find('(LOWER(username)=? OR LOWER(email)=?)', array(
            strtolower($this->username),
            strtolower($this->username),
        ));
        if (!$user) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }
        if ($account->activatedField && !$user->{$account->activatedField}) {
            $this->errorCode = self::ERROR_NOT_ACTIVATED;
            return false;
        }
        if ($account->disabledField && $user->{$account->disabledField}) {
            $this->errorCode = self::ERROR_DISABLED;
            return false;
        }
        if (!$this->skipPassword && !CPasswordHelper::verifyPassword($this->password, $user->{$account->passwordField})) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        }
        $this->_id = $user->primaryKey;
        $this->username = $account->usernameField && $user->{$account->usernameField} ? $user->{$account->usernameField} : $user->{$account->emailField};
        $this->errorCode = self::ERROR_NONE;
        return true;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

}
