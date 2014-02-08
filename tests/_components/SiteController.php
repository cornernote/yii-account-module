<?php

/**
 * SiteController for Tests
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-email-module
 */
class SiteController extends CController
{

    public $layout = 'tests._views.layouts.column1';

    public function actionIndex()
    {
        $this->renderText('Hello ' . (Yii::app()->user->isGuest ? 'guest' : Yii::app()->user->user->username));
    }

}