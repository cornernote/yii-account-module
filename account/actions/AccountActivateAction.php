<?php

/**
 * AccountActivateAction
 *
 * @property AccountController $controller
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
     * @var array
     */
    public $welcomeEmailCallback = array('AccountEmailManager', 'sendAccountWelcome');

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

        /** @var AccountActivate $accountActivate */
        $accountActivate = new $this->formClass();
        $accountActivate->userClass = $this->controller->userClass;
        $accountActivate->userIdentityClass = $this->controller->userIdentityClass;
        $accountActivate->statusField = $this->controller->statusField;

        // redirect if the key is invalid
        if (!$accountActivate->activate($id, $token)) {
            Yii::app()->user->addFlash(Yii::t('account', 'Invalid key.'), 'error');
            $this->controller->redirect(Yii::app()->user->loginUrl);
        }

        // account is active, redirect
        Yii::app()->user->addFlash(Yii::t('account', 'Your account has been activated and you have been logged in.'), 'success');
        call_user_func_array($this->welcomeEmailCallback, array($accountSignUp->user)); // AccountEmailManager::sendAccountWelcome($accountSignUp->user);
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

}
