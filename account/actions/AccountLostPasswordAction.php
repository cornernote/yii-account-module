<?php

/**
 * AccountLostPasswordAction
 *
 * @property AccountUserController $controller
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
class AccountLostPasswordAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.lost_password';

    /**
     * @var string
     */
    public $formClass = 'AccountLostPassword';

    /**
     * @var string|array
     */
    private $_returnUrl;

    /**
     * Request an email to be sent which will contain a secure link to allow a password reset.
     */
    public function run()
    {
        // redirect if logged in
        if (!Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        /** @var AccountLostPassword $accountLostPassword */
        $accountLostPassword = new $this->formClass();

        // collect user input
        if (isset($_POST[$this->formClass])) {
            $accountLostPassword->attributes = $_POST[$this->formClass];
            if ($accountLostPassword->validate()) {
                call_user_func_array($account->emailCallbackLostPassword, array($accountLostPassword->user)); // EEmailManager::sendAccountLostPassword($user);
                Yii::app()->user->addFlash(Yii::t('account', 'Password reset instructions have been sent to :email. Please check your email.', array(
                    ':email' => $accountLostPassword->user->{$account->emailField}
                )), 'success');
                $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
            }
        }

        // display the lost password form
        $this->controller->render($this->view, array(
            'accountLostPassword' => $accountLostPassword,
        ));
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        if (!$this->_returnUrl)
            $this->_returnUrl = Yii::app()->user->loginUrl;
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
