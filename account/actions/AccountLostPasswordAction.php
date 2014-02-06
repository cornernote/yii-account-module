<?php

/**
 * AccountLostPasswordAction
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
class AccountLostPasswordAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.lost_password';

    /**
     * @var string
     */
    public $formClass = 'AccountLostPassword';

    /**
     * @var string
     */
    public $userClass = 'User';

    /**
     * @var string
     */
    public $emailCallback = array('EEmailManager', 'sendAccountLostPassword');

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

        // enable recaptcha after 3 attempts
        $attemptKey = "lostPassword.attempt.{$_SERVER['REMOTE_ADDR']}";
        $attempts = $app->cache->get($attemptKey);
        if (!$attempts)
            $attempts = 0;
        $scenario = ($attempts >= 3 && isset($app->reCaptcha)) ? 'recaptcha' : '';

        /** @var AccountLostPassword $accountLostPassword */
        $accountLostPassword = new $this->formClass($scenario);
        $accountLostPassword->userClass = $this->userClass;

        // collect user input data
        if (isset($_POST[$this->formClass])) {
            $accountLostPassword->attributes = $_POST[$this->formClass];

            if ($accountLostPassword->validate()) {
                $user = CActiveRecord::model($this->userClass)->findbyPk($accountLostPassword->user_id);
                call_user_func_array($this->emailCallback, array($user)); // EEmailManager::sendAccountLostPassword($user);
                $app->user->addFlash(sprintf(Yii::t('account', 'Password reset instructions have been sent to %s. Please check your email.'), $user->email), 'success');
                $app->cache->delete($attemptKey);
                $this->controller->redirect($app->user->loginUrl);
            }
            // remove all other errors on recaptcha error
            if (isset($accountLostPassword->errors['recaptcha'])) {
                $errors = $accountLostPassword->errors['recaptcha'];
                $accountLostPassword->clearErrors();
                foreach ($errors as $error)
                    $accountLostPassword->addError('recaptcha', $error);
            }
            $app->cache->set($attemptKey, ++$attempts);

        }

        // display the lost password form
        $this->controller->render($this->view, array(
            'user' => $accountLostPassword,
            'recaptcha' => ($attempts >= 3 && isset($app->reCaptcha)) ? true : false,
        ));
    }

}
