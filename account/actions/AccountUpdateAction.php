<?php

/**
 * AccountUpdateAction
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
class AccountUpdateAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.update';

    /**
     * @var string
     */
    public $formClass = 'AccountUpdate';

    /**
     * @var string
     */
    public $userClass = 'User';

    /**
     * @var string
     */
    public $redirectUrl = array('/account/index');

    /**
     * User is updating their account details
     */
    public function run()
    {
        $user = $this->loadModel(Yii::app()->user->id, $this->userClass);
        $user->scenario = 'account';

        if (isset($_POST[$this->userClass])) {
            $user->attributes = $_POST[$this->userClass];
            if ($user->save()) {
                Yii::app()->user->addFlash(Yii::t('account', 'Your account has been saved.'), 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl($this->redirectUrl));
            }
        }

        $this->render($this->view, array(
            'user' => $user,
        ));
    }

}
