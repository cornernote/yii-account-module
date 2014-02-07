<?php
/**
 * Global Test Config
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */

return array(
    'basePath' => BASE_PATH,
    'runtimePath' => realpath(BASE_PATH . '/_runtime'),
    'import' => array(
        'account.components.*',
        'account.models.*',
        'bootstrap.helpers.TbHtml',
    ),
    'aliases' => array(
        'account' => realpath(BASE_PATH . '/../account'),
        'vendor' => realpath(BASE_PATH . '/../vendor'),
        'bootstrap' => realpath(BASE_PATH . '/../vendor/crisu83/yiistrap'),
    ),
    'controllerMap' => array(
        'site' => 'application._components.SiteController',
    ),
    'components' => array(
        'assetManager' => array(
            'basePath' => realpath(BASE_PATH . '/_www/assets'),
        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
        'db' => array(
            'connectionString' => 'sqlite:' . realpath(BASE_PATH . '/_runtime') . '/test.db',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
        ),
        'user' => array(
            'class' => 'system.web.auth.CWebUser',
//            'behaviors' => array(
//                'webUserFlash' => array(
//                    'class' => 'dressing.behaviors.YdWebUserFlashBehavior',
//                ),
//            ),
            'allowAutoLogin' => true,
            'loginUrl' => array('/account/user/login'),
        ),
    ),
    'modules' => array(
        'account' => array(
            'class' => 'account.AccountModule',
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'generatorPaths' => array(
                'vendor.cornernote.gii-modeldoc-generator',
                'bootstrap.gii',
            ),
            'ipFilters' => array('127.0.0.1'),
            'password' => false,
        ),
    ),
);