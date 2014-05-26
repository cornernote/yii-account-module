<?php

/**
 * AccountUserController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountUserController extends CController
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
        return array(
            array('allow',
                'actions' => array('login', 'logout', 'lostPassword', 'resetPassword', 'signUp', 'activate', 'resendActivation', 'hybridAuth'),
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
        return array(
            'signUp' => array(
                'class' => 'account.actions.AccountSignUpAction',
            ),
            'activate' => array(
                'class' => 'account.actions.AccountActivateAction',
            ),
            'resendActivation' => array(
                'class' => 'account.actions.AccountResendActivationAction',
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
            'hybridAuth' => array(
                'class' => 'account.actions.AccountHybridAuthAction',
            ),
        );
    }

    /**
     * @param CAction $action
     * @throws CHttpException
     * @return bool
     */
    public function beforeAction($action)
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        if (!$account->useAccountUserController)
            throw new CHttpException(404, Yii::t('account', 'Page not found.'));
        $this->layout = $account->layout;
        return true;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        if (!empty($account->modelMap[get_class($this)]['behaviors']))
            return $account->modelMap[get_class($this)]['behaviors'];
        return parent::behaviors();
    }
}
