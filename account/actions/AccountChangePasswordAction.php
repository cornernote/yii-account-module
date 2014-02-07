<?php

/**
 * AccountChangePasswordAction
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
class AccountChangePasswordAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.change_password';

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
    public $redirectUrl = array('/account/index');

    /**
     * User is attempting to change their password
     */
    public function run()
    {
        /** @var User $user */
        $user = $this->loadModel(Yii::app()->user->id, $this->userClass);
        /** @var AccountPassword $accountPassword */
        $accountPassword = new $this->formClass('changePassword');
        if (isset($_POST['AccountPassword'])) {
            $accountPassword->attributes = $_POST['AccountPassword'];
            if ($accountPassword->validate()) {
                $user->password = $user->hashPassword($accountPassword->password);
                if ($user->save(false)) {
                    Yii::app()->user->addFlash(Yii::t('account', 'Your password has been saved.'), 'success');
                    $this->redirect($this->redirectUrl);
                }
            }
        }
        $this->controller->render($this->view, array(
            'accountPassword' => $accountPassword,
        ));
    }

}
