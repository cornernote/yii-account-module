<?php

/**
 * AccountChangePasswordAction
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
class AccountChangePasswordAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.change_password';

    /**
     * @var string
     */
    public $formClass = 'AccountChangePassword';

    /**
     * @var string|array
     */
    private $_returnUrl;

    /**
     * Change own password details after verifying current password.
     */
    public function run()
    {
        Yii::app()->getModule('account');
        /** @var AccountChangePassword $accountChangePassword */
        $accountChangePassword = new $this->formClass();

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
            $this->_returnUrl = array('account/index');
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
