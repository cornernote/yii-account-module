<?php

/**
 * AccountSignUpAction
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
class AccountSignUpAction extends CAction
{
    /**
     * @var string
     */
    public $view = 'account.views.account.sign_up';

    /**
     * @var string
     */
    public $formClass = 'AccountSignUp';

    /**
     * @var string|array
     */
    private $_returnUrl;

    /**
     * Sign up for a new account.
     */
    public function run()
    {
        // redirect if logged in
        if (!Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        /** @var AccountSignUp $accountSignUp */
        $accountSignUp = new $this->formClass();

        // collect user input
        if (isset($_POST[$this->formClass])) {
            $accountSignUp->attributes = $_POST[$this->formClass];
            if ($accountSignUp->save()) {
                if (!isset($accountSignUp->user->{$account->activatedField}) || $account->activatedAfterSignUp) {
                    Yii::app()->user->addFlash(Yii::t('account', 'Your account has been created and you have been logged in.'), 'success');
                    if ($account->emailCallbackWelcome) {
                        call_user_func_array($account->emailCallbackWelcome, array($accountSignUp->user)); // AccountEmailManager::sendAccountWelcome($accountSignUp->user);
                    }
                }
                else {
                    Yii::app()->user->addFlash(Yii::t('account', 'Your account has been created. Please check your email for activation instructions.'), 'success');
                    if ($account->emailCallbackActivate) {
                        call_user_func_array($account->emailCallbackActivate, array($accountSignUp->user)); // AccountEmailManager::sendAccountActivate($accountSignUp->user);
                    }
                }
                $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
            }
        }

        // display the sign up form
        $this->controller->render($this->view, array(
            'accountSignUp' => $accountSignUp,
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
