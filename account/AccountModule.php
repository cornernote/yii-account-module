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
     * @var string The ID of the CDbConnection application component. If not set, a SQLite3
     * database will be automatically created in <code>protected/runtime/account-AccountVersion.db</code>.
     */
    public $connectionID;

    /**
     * @var boolean Whether the DB tables should be created automatically if they do not exist. Defaults to true.
     * If you already have the table created, it is recommended you set this property to be false to improve performance.
     */
    public $autoCreateTables = true;

    /**
     * @var bool If we should allow access to the module controllers.
     * Set to false if you only want to use the actions in your own controllers, the controllers will then throw a 404 error.
     */
    public $useAccountUserController = true;

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
    public $activatedField = 'activated';

    /**
     * @var string
     */
    public $activatedAfterSignUp = 1;

    /**
     * @var string
     */
    public $userIdentityClass = 'AccountUserIdentity';

    /**
     * @var int Default setting for Remember Me checkbox on login page
     */
    public $rememberDefault = 0;

    /**
     * @var int
     */
    public $rememberDuration = 2592000; // 30 days

    /**
     * @var bool If we should spool the emails, or send immediately.
     */
    public $emailSpool = true;

    /**
     * @var array
     */
    public $emailCallbackActivate = array('AccountEmailManager', 'sendAccountActivate');

    /**
     * @var array
     */
    public $emailCallbackWelcome = array('AccountEmailManager', 'sendAccountWelcome');

    /**
     * @var string
     */
    public $emailCallbackLostPassword = array('AccountEmailManager', 'sendAccountLostPassword');

    /**
     * @var bool
     */
    public $reCaptcha = true;

    /**
     * @var int The number of login attempts before reCaptcha is used.
     */
    public $reCaptchaLoginCount = 3;

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
     * @var array Map of model info including relations and behaviors.
     */
    public $modelMap = array();

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
     * @var CDbConnection the DB connection instance
     */
    private $_db;

    /**
     * @var string Url to the assets
     */
    private $_assetsUrl;

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
     * @return CDbConnection the DB connection instance
     * @throws CException if {@link connectionID} does not point to a valid application component.
     */
    public function getDbConnection()
    {
        if ($this->_db !== null)
            return $this->_db;
        elseif (($id = $this->connectionID) !== null) {
            if (($this->_db = Yii::app()->getComponent($id)) instanceof CDbConnection)
                return $this->_db;
            else
                throw new CException(Yii::t('account', 'AccountModule.connectionID "{id}" is invalid. Please make sure it refers to the ID of a CDbConnection application component.',
                    array('{id}' => $id)));
        }
        else {
            $dbFile = Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . 'account-' . $this->getVersion() . '.db';
            return $this->_db = new CDbConnection('sqlite:' . $dbFile);
        }
    }

    /**
     * Sets the DB connection used by the cache component.
     * @param CDbConnection $value the DB connection instance
     * @since 1.1.5
     */
    public function setDbConnection($value)
    {
        $this->_db = $value;
    }

    /**
     * @return string the base URL that contains all published asset files of email.
     */
    public function getAssetsUrl()
    {
        if ($this->_assetsUrl === null)
            $this->_assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('email.assets'));
        return $this->_assetsUrl;
    }

    /**
     * @param string $value the base URL that contains all published asset files of email.
     */
    public function setAssetsUrl($value)
    {
        $this->_assetsUrl = $value;
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
