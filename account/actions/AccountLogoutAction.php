<?php

/**
 * AccountLogoutAction
 *
 * @property CController $controller
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 *
 * @package account.actions
 */
class AccountLogoutAction extends CAction
{

    /**
     *
     */
    public function run()
    {
        $user = Yii::app()->getUser();
        $user->logout();
        $this->controller->redirect($user->loginUrl);
    }

}
