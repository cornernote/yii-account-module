<?php

/**
 * AccountModule
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountModule extends CWebModule
{

    /**
     * @var string The layout used for module controllers.
     */
    public $layout = 'account.views.layouts.column1';

    /**
     * @var string
     */
    public $userClass = 'AccountUser';

    /**
     * @var string
     */
    public $firstNameField = 'first_name';

    /**
     * @var string
     */
    public $lastNameField = 'last_name';

    /**
     * @var string
     */
    public $emailField = 'email';

    /**
     * @var string
     */
    public $usernameField = 'username';

    /**
     * @var string
     */
    public $passwordField = 'password';

    /**
     * @var string
     */
    public $statusField = 'status';

    /**
     * @var string
     */
    public $userIdentityClass = 'UserIdentity';

    /**
     * @var bool
     */
    public $reCaptcha = true;

    /**
     * @var string
     */
    public $reCaptchaPublicKey = '6LeBItQSAAAAAG_umhiD0vyxXbDFbVMPA0kxZUF6';

    /**
     * @var string
     */
    public $reCaptchaPrivateKey = '6LeBItQSAAAAALA4_G05e_-fG5yH_-xqQIN8AfTD';

    /**
     * @var string
     */
    public $reCaptchaServer = 'http://www.google.com/recaptcha/api';

    /**
     * @var string
     */
    public $reCaptchaSecureServer = 'https://www.google.com/recaptcha/api';

    /**
     * @var string
     */
    public $reCaptchaVerifyServer = 'www.google.com';

    /**
     * @var array mapping from controller ID to controller configurations.
     */
    public $controllerMap = array(
        'user' => 'account.controllers.AccountUserController',
    );

    /**
     * @var string The path to YiiStrap.
     * Only required if you do not want YiiStrap in your app config, for example, if you are running YiiBooster.
     * Only required if you did not install using composer.
     * Please note:
     * - You must download YiiStrap even if you are using YiiBooster in your app.
     * - When using this setting YiiStrap will only loaded in the menu interface (eg: index.php?r=menu).
     */
    public $yiiStrapPath;

    /**
     * @return string
     */
    public static function powered()
    {
        return Yii::t('account', 'Powered by {yii-account-module}.', array('{yii-account-module}' => '<a href="http://cornernote.github.io/yii-account-module/" rel="external">Yii Account Module</a>'));
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return trim(file_get_contents(dirname(__FILE__) . '/version.txt'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Account';
    }

    /**
     * Initializes the account module.
     */
    public function init()
    {
        parent::init();

        // setup paths
        Yii::setPathOfAlias('account', dirname(__FILE__));
        $this->setImport(array(
            'account.models.*',
            'account.components.*',
        ));

        // map models
        foreach ($this->getDefaultModelMap() as $method => $data)
            foreach ($data as $name => $options)
                if (empty($this->modelMap[$method][$name]))
                    $this->modelMap[$method][$name] = $options;

        // init yiiStrap
        $this->initYiiStrap();
    }

    /**
     * @return array
     */
    public function getDefaultModelMap()
    {
        return array();
    }

    /**
     * Setup yiiStrap, works even if YiiBooster is used in main app.
     */
    public function initYiiStrap()
    {
        // check that we are in a web application
        if (!(Yii::app() instanceof CWebApplication))
            return;
        // and in this module
        $route = explode('/', Yii::app()->urlManager->parseUrl(Yii::app()->request));
        if ($route[0] != $this->id)
            return;
        // and yiiStrap is not configured
        if (Yii::getPathOfAlias('bootstrap') && file_exists(Yii::getPathOfAlias('bootstrap.helpers') . '/TbHtml.php'))
            return;
        // try to guess yiiStrapPath
        if ($this->yiiStrapPath === null)
            $this->yiiStrapPath = Yii::getPathOfAlias('vendor.crisu83.yiistrap');
        // check for valid path
        if (!realpath($this->yiiStrapPath))
            return;
        // setup yiiStrap components
        Yii::setPathOfAlias('bootstrap', realpath($this->yiiStrapPath));
        Yii::import('bootstrap.helpers.TbHtml');
        Yii::app()->setComponents(array(
            'bootstrap' => array(
                'class' => 'bootstrap.components.TbApi',
            ),
        ), false);
    }

}
