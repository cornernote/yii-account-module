<?php

/**
 * AccountLoginAction
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
     * @var string|array
     */
    private $_returnUrl;

    /**
     * Login to an account.
     */
    public function run()
    {
        // redirect if logged in
        if (!Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        /** @var AccountLogin $accountLogin */
        $accountLogin = new $this->formClass();

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
            $accountLogin->remember = $account->rememberDefault;
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
