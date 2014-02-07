<?php

/**
 * AccountActivate allows account activation by using a valid link.
 * It is used by the 'activate' action of 'AccountController'.
 *
 * @property AccountUser $user
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
class AccountActivate extends CComponent
{

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var string
     */
    public $userClass = 'AccountUser';

    /**
     * @var string
     */
    public $statusField = 'status';

    /**
     * @var string
     */
    public $userIdentityClass = 'UserIdentity';

    /**
     * @var AccountUser
     */
    public $_user;

    /**
     * @var UserIdentity
     */
    public $_userIdentity;

    /**
     * Activates the users account.
     * @param int $user_id
     * @param string $token
     */
    public function activate($user_id, $token)
    {
        $this->user_id = $user_id;
        if (!$this->user)
            return false;
        if (!Yii::app()->tokenManager->checkToken('AccountActivate', $user_id, $token))
            return false;
        $this->user->{$this->statusField} = 1;
        if (!$this->user->save(false))
            return false;
        Yii::app()->tokenManager->useToken('AccountActivate', $user_id, $token);
        return true;
    }

    /**
     * @return AccountUser
     */
    public function getUser()
    {
        if (!$this->_user)
            $this->_user = CActiveRecord::model($this->userClass)->findByPk($this->user_id);
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
