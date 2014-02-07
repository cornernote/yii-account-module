<?php

/**
 * AccountActivate allows account activation by using a valid link.
 * It is used by the 'activate' action of 'AccountUserController'.
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
     * @var AccountUser
     */
    public $_user;

    /**
     * Activates the users account.
     * @param int $user_id
     * @param string $token
     * @return bool
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

} 
