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
     * @var string
     */
    public $userClass = 'AccountUser';

    /**
     * @var string
     */
    public $firstNameField = 'first_name';

    /**
     * @var string
     */
    public $lastNameField = 'last_name';

    /**
     * @var string
     */
    public $emailField = 'email';

    /**
     * @var string
     */
    public $usernameField = 'username';

    /**
     * @var string
     */
    public $passwordField = 'password';

    /**
     * @var string
     */
    public $statusField = 'status';

    /**
     * @var string
     */
    public $userIdentityClass = 'UserIdentity';

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
        return array(
            array('allow',
                'actions' => array('login', 'logout', 'lostPassword', 'resetPassword', 'signUp', 'activate'),
                'users' => array('*'), // anyone
            ),
            array('allow',
                'actions' => array('view', 'update', 'changePassword'),
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
        Yii::import('account.models.*');
        Yii::import('account.components.*');
        return array(
            'signUp' => array(
                'class' => 'account.actions.AccountSignUpAction',
            ),
            'activate' => array(
                'class' => 'account.actions.AccountActivateAction',
            ),
            'lostPassword' => array(
                'class' => 'account.actions.AccountLostPasswordAction',
            ),
            'resetPassword' => array(
                'class' => 'account.actions.AccountResetPasswordAction',
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
            'changePassword' => array(
                'class' => 'account.actions.AccountChangePasswordAction',
            ),
        );
    }

}
