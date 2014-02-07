<?php

/**
 * AccountSignUpAction
 *
 * @property CController $controller
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountSignUpAction extends CAction
{
    /**
     * @var string
     */
    public $view = 'account.views.account.sign_up';

    /**
     * @var string
     */
    public $formClass = 'AccountSignUp';

    /**
     * @var
     */
    public $userClass = 'User';

    /**
     * @var
     */
    public $userIdentityClass = 'CUserIdentity';

    /**
     * @var array
     */
    public $emailCallback = array('AccountEmailManager', 'sendAccountSignUp');

    /**
     *
     */
    public function run()
    {
        $app = Yii::app();

        // redirect if the user is already logged in
        if ($app->user->id) {
            $this->controller->redirect($app->homeUrl);
        }

        /** @var AccountSignUp $accountSignUp */
        $accountSignUp = new $this->formClass();
        $accountSignUp->userClass = $this->userClass;
        $accountSignUp->userIdentityClass = $this->userIdentityClass;

        // collect user input data
        if (isset($_POST[$this->formClass])) {
            $accountSignUp->attributes = $_POST[$this->formClass];
            if ($accountSignUp->save()) {
                call_user_func_array($this->emailCallback, array($accountSignUp->user)); // AccountEmailManager::sendAccountSignUp($accountSignUp->user);
                $this->controller->redirect($app->returnUrl->getUrl($app->user->returnUrl));
            }
        }

        // display the sign up form
        $this->controller->render($this->view, array(
            'accountSignUp' => $accountSignUp,
        ));

    }

}
