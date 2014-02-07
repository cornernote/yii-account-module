<?php

/**
 * AccountLostPasswordAction
 *
 * @property AccountController $controller
 * @property array|string $returnUrl
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
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
     * @var string
     */
    public $emailCallback = array('AccountEmailManager', 'sendAccountLostPassword');

    /**
     * Allows the user to request an email containing password reset instructions.
     */
    public function run()
    {
        // redirect if logged in
        if (!Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        /** @var AccountLostPassword $accountLostPassword */
        $accountLostPassword = new $this->formClass();
        $accountLostPassword->userClass = $this->controller->userClass;
        $accountLostPassword->emailField = $this->controller->emailField;
        $accountLostPassword->usernameField = $this->controller->usernameField;

        // collect user input
        if (isset($_POST[$this->formClass])) {
            $accountLostPassword->attributes = $_POST[$this->formClass];
            if ($accountLostPassword->validate()) {
                call_user_func_array($this->emailCallback, array($accountLostPassword->user)); // EEmailManager::sendAccountLostPassword($user);
                Yii::app()->user->addFlash(Yii::t('account', 'Password reset instructions have been sent to :email. Please check your email.', array(
                    ':email' => $accountLostPassword->user->{$accountLostPassword->emailField}
                )), 'success');
                $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
            }
        }

        // display the lost password form
        $this->controller->render($this->view, array(
            'user' => $accountLostPassword,
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
