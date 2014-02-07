<?php

/**
 * AccountLoginAction
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
class AccountLoginAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.login';

    /**
     * @var string
     */
    public $formClass = 'AccountLogin';

    /**
     * @var int Default setting for Remember Me checkbox on login page
     */
    public $defaultRemember = 0;

    /**
     * Allows the user to login to their account.
     */
    public function run()
    {
        // redirect if logged in
        if (!Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        /** @var AccountLogin $accountLogin */
        $accountLogin = new $this->formClass();
        $accountLogin->userIdentityClass = $this->controller->userIdentityClass;

        // collect user input
        if (isset($_POST[$this->formClass])) {
            $accountLogin->attributes = $_POST[$this->formClass];
            if ($accountLogin->login()) {
                Yii::app()->user->addFlash(Yii::t('account', 'You have successfully logged in.'), 'success');
                $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
            }
        }
        // assign default values
        else {
            $accountLogin->remember = $this->defaultRemember;
        }

        // display the login form
        $this->controller->render($this->view, array(
            'accountLogin' => $accountLogin,
        ));
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        if (!$this->_returnUrl)
            $this->_returnUrl = Yii::app()->user->returnUrl;
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
