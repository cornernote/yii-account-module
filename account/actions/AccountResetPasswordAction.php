<?php

/**
 * AccountResetPasswordAction
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
class AccountResetPasswordAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.reset_password';

    /**
     * @var string
     */
    public $formClass = 'AccountResetPassword';

    /**
     * @var string|array
     */
    private $_returnUrl;

    /**
     * Checks for valid link and allows resetting the account password.
     *
     * @param $user_id
     * @param $token
     */
    public function run($user_id, $token)
    {
        // redirect if logged in
        if (!Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        Yii::app()->getModule('account');
        /** @var AccountResetPassword $accountResetPassword */
        $accountResetPassword = new $this->formClass();
        $accountResetPassword->user_id = $user_id;
        $accountResetPassword->token = $token;

        // redirect if the token is invalid
        if (!$accountResetPassword->checkToken($user_id, $token)) {
            Yii::app()->user->addFlash(Yii::t('account', 'Invalid token.'), 'error');
            $this->controller->redirect(Yii::app()->user->loginUrl);
        }

        // collect user input
        if (isset($_POST[$this->formClass])) {
            $accountResetPassword->attributes = $_POST[$this->formClass];
            if ($accountResetPassword->save()) {
                Yii::app()->user->addFlash(Yii::t('account', 'Your password has been saved and you have been logged in.'), 'success');
                $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
            }
        }

        // render the reset password form
        $this->controller->render($this->view, array(
            'accountResetPassword' => $accountResetPassword,
        ));
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
