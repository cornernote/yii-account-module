<?php

/**
 * AccountViewAction
 *
 * @property AccountController $controller
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountViewAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.view';

    /**
     * Allows the user to view their account details.
     */
    public function run()
    {
        /** @var AccountUser $user */
        $user = CActiveRecord::model($this->controller->userClass)->findByPk(Yii::app()->user->id);
        if (!$user)
            throw new CHttpException(404, Yii::t('account', 'The requested page does not exist.'));

        // display the view account page
        $this->controller->render($this->view, array(
            'user' => $user,
        ));
    }

}
