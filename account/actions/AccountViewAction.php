<?php

/**
 * AccountViewAction
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
class AccountViewAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.view';

    /**
     *
     */
    public function run()
    {
        /** @var User $user */
        $user = $this->loadModel(Yii::app()->user->id, 'User');
        $this->controller->render($this->view, array(
            'user' => $user,
        ));
    }

}
