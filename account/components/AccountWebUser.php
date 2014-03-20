<?php

/**
 * AccountWebUser
 *
 * @see AccountWebUserBehavior
 * @property User $user
 * @method User getUser()
 * @method void addFlash(string $msg, $class = 'info')
 * @method string multiFlash()
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountWebUser extends CWebUser
{

    /**
     * Initializes the application component.
     * This method overrides the parent implementation by starting session,
     * performing cookie-based authentication if enabled, and updating the flash variables.
     */
    public function init()
    {
        if (get_class(Yii::app()) != 'CConsoleApplication') {
            parent::init();
        }
    }

}