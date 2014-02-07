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
     * Error - Status Inactive
     */
    const ERROR_STATUS_INACTIVE = 3;

    /**
     * @var int
     */
    private $_id;

    /**
     * Authentication
     *
     * @param bool $checkPassword
     * @return bool
     */
    public function authenticate($checkPassword = true)
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
        if ($account->statusField && !$user->{$account->statusField}) {
            $this->errorCode = self::ERROR_STATUS_INACTIVE;
            return false;
        }
        if ($checkPassword && !CPasswordHelper::verifyPassword($this->password, $user->{$account->passwordField})) {
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
