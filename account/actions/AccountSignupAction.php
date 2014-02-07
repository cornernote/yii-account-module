<?php

/**
 * AccountSignupAction
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
class AccountSignupAction extends CAction
{
    /**
     * @var string
     */
    public $view = 'account.views.account.signup';

    /**
     * @var string
     */
    public $formClass = 'AccountSignup';

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
    public $emailCallback = array('EEmailManager', 'sendAccountSignup');

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

        /** @var AccountSignup $accountSignup */
        $accountSignup = new $this->formClass();
        $accountSignup->userClass = $this->userClass;
        $accountSignup->userIdentityClass = $this->userIdentityClass;

        // collect user input data
        if (isset($_POST[$this->formClass])) {
            $accountSignup->attributes = $_POST[$this->formClass];
            if ($accountSignup->save()) {
                call_user_func_array($this->emailCallback, array($accountSignup->user)); // EEmailManager::sendAccountSignup($accountSignup->user);
                $this->controller->redirect($app->returnUrl->getUrl($app->user->returnUrl));
            }
        }

        // display the signup form
        $this->controller->render($this->view, array(
            'accountSignup' => $accountSignup,
        ));

    }

}
