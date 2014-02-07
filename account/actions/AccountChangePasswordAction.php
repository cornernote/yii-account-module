<?php

/**
 * AccountChangePasswordAction
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
class AccountChangePasswordAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.change_password';

    /**
     * @var string
     */
    public $formClass = 'AccountPassword';

    /**
     * @var string
     */
    private $_returnUrl = array('/account/index');

    /**
     * Allows user to change their password
     */
    public function run()
    {
        /** @var AccountChangePassword $accountChangePassword */
        $accountChangePassword = new $this->formClass();
        $accountChangePassword->userClass = $this->controller->userClass;
        $accountChangePassword->passwordField = $this->controller->passwordField;

        // collect user input
        if (isset($_POST[$this->formClass])) {
            $accountChangePassword->attributes = $_POST[$this->formClass];
            if ($accountChangePassword->save()) {
                Yii::app()->user->addFlash(Yii::t('account', 'Your password has been saved.'), 'success');
                $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
            }
        }

        // display the change password form
        $this->controller->render($this->view, array(
            'accountChangePassword' => $accountChangePassword,
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
