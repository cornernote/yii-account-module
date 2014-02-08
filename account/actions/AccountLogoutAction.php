<?php

/**
 * AccountLogoutAction
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
class AccountLogoutAction extends CAction
{

    /**
     * @var string|array
     */
    private $_returnUrl;

    /**
     * Logout from an account.
     */
    public function run()
    {
        // redirect if not logged in
        if (Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        Yii::app()->user->logout();
        Yii::app()->session->open();
        Yii::app()->user->addFlash(Yii::t('account', 'Your have been logged out.'), 'success');
        $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
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
