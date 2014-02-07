<?php

/**
 * AccountLogoutAction
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
class AccountLogoutAction extends CAction
{

    /**
     * Logs the user out.
     */
    public function run()
    {
        // redirect if not logged in
        if (Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        Yii::app()->user->logout();
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
