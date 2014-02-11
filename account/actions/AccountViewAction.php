<?php

/**
 * AccountViewAction
 *
 * @property AccountUserController $controller
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
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
     * View own account details.
     */
    public function run()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        /** @var AccountUser $user */
        $accountUser = CActiveRecord::model($account->userClass)->findByPk(Yii::app()->user->id);
        if (!$accountUser)
            throw new CHttpException(404, Yii::t('account', 'The requested page does not exist.'));

        // display the view account page
        $this->controller->render($this->view, array(
            'accountUser' => $accountUser,
        ));
    }

}
