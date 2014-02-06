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
 * @package account.controllers
 */
class AccountController extends CController
{

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('login', 'lostPassword', 'resetPassword'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('signup'),
                'users' => array('?'),
            ),
            array('allow',
                'actions' => array('logout', 'index', 'update', 'password', 'settings'),
                'users' => array('@'),
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
            'signup' => array(
                'class' => 'account.actions.AccountSignupAction',
            ),
            'login' => array(
                'class' => 'account.actions.AccountLoginAction',
            ),
            'logout' => array(
                'class' => 'account.actions.AccountLogoutAction',
            ),
            'lostPassword' => array(
                'class' => 'account.actions.AccountLostPasswordAction',
            ),
            'resetPassword' => array(
                'class' => 'account.actions.AccountResetPasswordAction',
            ),
        );
    }

    /**
     * @param string $view the view to be rendered
     * @return bool
     */
    public function beforeRender($view)
    {
        $this->pageTitle = $this->pageHeading = Yii::t('account', 'My Account');
        //if ($view != 'login')
        //    $this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_USER);
        return parent::beforeRender($view);
    }

    /**
     * Displays current logged in user.
     */
    public function actionIndex()
    {
        $user = $this->loadModel(Yii::app()->user->id, 'User');
        $this->render('view', array(
            'user' => $user,
        ));
    }

    /**
     * Updates your own user details.
     */
    public function actionUpdate()
    {
        $user = $this->loadModel(Yii::app()->user->id, 'User');
        $user->scenario = 'account';

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                Yii::app()->user->addFlash('Your account has been saved.', 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl(array('/account/index')));
            }
        }

        $this->render('update', array(
            'user' => $user,
        ));
    }

    /**
     * Updates your own user password.
     */
    public function actionPassword()
    {
        $user = $this->loadModel(Yii::app()->user->id, 'User');
        $accountPassword = new AccountPassword('password');
        if (isset($_POST['AccountPassword'])) {
            $accountPassword->attributes = $_POST['AccountPassword'];
            if ($accountPassword->validate()) {
                $user->password = $user->hashPassword($accountPassword->password);
                if ($user->save(false)) {
                    Yii::app()->user->addFlash('Your password has been saved.', 'success');
                    $this->redirect(array('/account/index'));
                }
            }
        }
        $this->render('password', array('user' => $accountPassword));

    }

}
