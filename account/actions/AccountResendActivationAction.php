<?php

/**
 * AccountResendActivationAction
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
class AccountResendActivationAction extends CAction
{
    /**
     * @var string
     */
    public $view = 'account.views.account.resend_activation';

    /**
     * @var string
     */
    public $formClass = 'AccountResendActivation';

    /**
     * @var string|array
     */
    private $_returnUrl;

    /**
     * Request new activation email.
     */
    public function run($username = null)
    {
        // redirect if logged in
        if (!Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        /** @var AccountResendActivation $accountResendActivation */
        $accountResendActivation = new $this->formClass();

        // collect user input
        if (isset($_POST[$this->formClass])) {
            $accountResendActivation->attributes = $_POST[$this->formClass];
            if ($accountResendActivation->validate()) {
                if (isset($accountResendActivation->user->{$account->activatedField}) && !$accountResendActivation->user->{$account->activatedField}) {
                    Yii::app()->user->addFlash(Yii::t('account', 'Account activation has been resent to :email. Please check your email for activation instructions.', array(':email' => $accountResendActivation->user->{$account->emailField})), 'success');
                    call_user_func_array($account->emailCallbackActivate, array($accountResendActivation->user)); // AccountEmailManager::sendAccountActivate($accountResendActivation->user);
                }
                else {
                    Yii::app()->user->addFlash(Yii::t('account', 'Your account is already active.'), 'error');
                }
                $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
            }
        }
        else {
            $accountResendActivation->email_or_username = $username;
        }

        // display the sign up form
        $this->controller->render($this->view, array(
            'accountResendActivation' => $accountResendActivation,
        ));
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        if (!$this->_returnUrl) {
            /** @var AccountModule $account */
            $account = Yii::app()->getModule('account');
            $this->_returnUrl = $account->activatedField && $account->activatedAfterSignUp ? Yii::app()->user->returnUrl : Yii::app()->homeUrl;
        }
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
