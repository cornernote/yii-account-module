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
        'tests' => realpath(BASE_PATH . '/../tests'),
        'email' => realpath(BASE_PATH . '/../vendor/cornernote/yii-email-module/email'),
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
        'cache' => array(
            'class' => 'CFileCache',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<action:(login|logout|signUp|activate|lostPassword)>' => '/account/user/<action>',
                'account/<action:(view|update|changePassword)>' => '/account/user/<action>',
            ),
        ),
        'emailManager' => array(
            'class' => 'email.components.EEmailManager',
            'swiftMailerPath' => realpath(BASE_PATH . '/../vendor/swiftmailer/swiftmailer/lib'),
        ),
        'tokenManager' => array(
            'class' => 'vendor.cornernote.yii-token-manager.token-manager.components.ETokenManager',
            'connectionID' => 'db',
        ),
        'returnUrl' => array(
            'class' => 'vendor.cornernote.yii-return-url.return-url.components.EReturnUrl',
        ),
        'user' => array(
            'class' => 'system.web.auth.CWebUser',
            'behaviors' => array(
                'accountWebUser' => array(
                    'class' => 'account.components.AccountWebUserBehavior',
                ),
            ),
            'allowAutoLogin' => true,
            'loginUrl' => array('/account/user/login'),
        ),
    ),
    'modules' => array(
        'account' => array(
            'class' => 'account.AccountModule',
            'connectionID' => 'db',
            'layout' => 'tests._views.layouts.column1',
            'reCaptcha' => false,
        ),
        'email' => array(
            'class' => 'email.EmailModule',
            'connectionID' => 'db',
            'controllerFilters' => array(),
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