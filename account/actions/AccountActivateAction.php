<?php

/**
 * AccountActivateAction
 *
 * @property AccountUserController $controller
 * @property AccountUser $user
 * @property array|string $returnUrl
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountActivateAction extends CAction
{

    /**
     * @var string
     */
    public $formClass = 'AccountActivate';

    /**
     * @var int
     */
    protected $user_id;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var AccountUser
     */
    private $_user;

    /**
     * @var string|array
     */
    private $_returnUrl;

    /**
     * Activate a new account once the secure email link is clicked.
     *
     * @param $user_id
     * @param $token
     */
    public function run($user_id, $token)
    {
        // redirect if logged in
        if (!Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $this->user_id = $user_id;
        $this->token = $token;

        // redirect if the key is invalid
        if (!$this->activate()) {
            Yii::app()->user->addFlash(Yii::t('account', 'Invalid key.'), 'error');
            $this->controller->redirect(Yii::app()->user->loginUrl);
        }

        // account is active, redirect
        Yii::app()->user->addFlash(Yii::t('account', 'Your account has been activated and you have been logged in.'), 'success');
        call_user_func_array($account->emailCallbackWelcome, array($this->user)); // AccountEmailManager::sendAccountWelcome($accountSignUp->user);
        $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        if (!$this->_returnUrl)
            $this->_returnUrl = Yii::app()->homeUrl;
        return $this->_returnUrl;
    }

    /**
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->_returnUrl = $returnUrl;
    }

    /**
     * Activates the users account.
     * @return bool
     */
    public function activate()
    {
        if (!$this->user)
            return false;
        if (!Yii::app()->tokenManager->checkToken('AccountActivate', $this->user_id, $this->token))
            return false;
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $this->user->{$account->statusField} = 1;
        if (!$this->user->save(false))
            return false;
        Yii::app()->tokenManager->useToken('AccountActivate', $this->user_id, $this->token);
        return true;
    }

    /**
     * @return AccountUser
     */
    public function getUser()
    {
        if (!$this->_user) {
            /** @var AccountModule $account */
            $account = Yii::app()->getModule('account');
            $this->_user = CActiveRecord::model($account->userClass)->findByPk($this->user_id);
        }
        return $this->_user;
    }
}
