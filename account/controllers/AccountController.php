<?php

/**
 * AccountController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountController extends CController
{

    /**
     * @var string
     */
    public $defaultAction = 'view';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        Yii::import('account.models.*');
        return array(
            array('allow',
                'actions' => array('login', 'lostPassword', 'resetPassword', 'signUp'),
                'users' => array('?'), // guest
            ),
            array('allow',
                'actions' => array('logout', 'view', 'update', 'changePassword'),
                'users' => array('@'), // authenticated
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'signUp' => array(
                'class' => 'account.actions.AccountSignUpAction',
            ),
            'login' => array(
                'class' => 'account.actions.AccountLoginAction',
            ),
            'logout' => array(
                'class' => 'account.actions.AccountLogoutAction',
            ),
            'view' => array(
                'class' => 'account.actions.AccountViewAction',
            ),
            'update' => array(
                'class' => 'account.actions.AccountUpdateAction',
            ),
            'lostPassword' => array(
                'class' => 'account.actions.AccountLostPasswordAction',
            ),
            'resetPassword' => array(
                'class' => 'account.actions.AccountResetPasswordAction',
            ),
            'changePassword' => array(
                'class' => 'account.actions.AccountChangePasswordAction',
            ),
        );
    }

}
