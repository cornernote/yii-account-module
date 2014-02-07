<?php

/**
 * AccountResetPasswordAction
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
class AccountResetPasswordAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.reset_password';

    /**
     * @var string
     */
    public $formClass = 'AccountPassword';

    /**
     * @var string
     */
    public $userClass = 'User';

    /**
     * @var string
     */
    public $userIdentityClass = 'CUserIdentity';

    /**
     * User clicked a link, check if it's valid and allow them to reset their password
     *
     * @param $id
     * @param $token
     */
    public function run($id, $token)
    {
        $app = Yii::app();

        // redirect if the user is already logged in
        if ($app->user->id) {
            $this->controller->redirect($app->homeUrl);
        }

        // redirect if the key is invalid
        $valid = true;
        $user = CActiveRecord::model($this->userClass)->findByPk($id);
        if (!$user) {
            $valid = false;
        }
        if ($valid) {
            $valid = Yii::app()->tokenManager->checkToken('AccountLostPassword', $id, $token);
        }
        if (!$valid) {
            $app->user->addFlash(Yii::t('account', 'Invalid key.'), 'error');
            $this->controller->redirect($app->user->loginUrl);
        }

        $accountPassword = new $this->formClass('lostPassword');
        if ($this->userClass && isset($accountPassword->userClass))
            $accountPassword->userClass = $this->userClass;
        if (isset($_POST[$this->formClass])) {
            $accountPassword->attributes = $_POST[$this->formClass];
            if ($accountPassword->validate()) {

                $user->password = $user->hashPassword($accountPassword->new_password);
                if (!$user->save(false)) {
                    $app->user->addFlash(Yii::t('account', 'Your password could not be saved.'), 'error');
                }

                $identity = new $this->userIdentityClass($user->email, $accountPassword->new_password);
                if ($identity->authenticate()) {
                    $app->user->login($identity);
                }

                Yii::app()->tokenManager->useToken('AccountLostPassword', $id, $token);

                $app->user->addFlash(Yii::t('account', 'Your password has been saved and you have been logged in.'), 'success');
                $this->controller->redirect($app->homeUrl);
            }
            else {
                $app->user->addFlash(Yii::t('account', 'Your password could not be saved.'), 'error');
            }
        }
        $this->controller->render($this->view, array(
            'user' => $accountPassword,
        ));
    }

}
