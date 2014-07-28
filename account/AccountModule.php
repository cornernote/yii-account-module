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
     * @var string
     */
    public $defaultController = 'account';

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
    public $useAccountAccountController = true;

    /**
     * @var string The layout used for module controllers.
     */
    public $layout = 'account.views.layouts.column1';

    /**
     * @var string The user class to use for user storage.
     */
    public $userClass = 'AccountUser';

    /**
     * @var string|bool The field to store the user's first name, or false to not store the first name.
     */
    public $firstNameField = 'first_name';

    /**
     * @var string|bool The field to store the user's last name, or false to not store the last name.
     */
    public $lastNameField = 'last_name';

    /**
     * @var string The field to store the user's email address.
     */
    public $emailField = 'email';

    /**
     * @var string|bool The field to store the user's username, or false to not store the username.
     */
    public $usernameField = 'username';

    /**
     * @var string The field to store the user's password.
     */
    public $passwordField = 'password';

    /**
     * @var string|bool The field to store the user's timezone, or false to not store the timezone.
     * @var string
     */
    public $timezoneField = 'timezone';

    /**
     * @var string|bool The field to store the user's activated status, or false to not support activation.
     */
    public $activatedField = 'activated';

    /**
     * @var string|bool The field to store the user's activated status, or false to not support disabling.
     */
    public $disabledField = 'disabled';

    /**
     * @var string The user class to use for hybrid auth user storage.
     */
    public $userHybridAuthClass = 'AccountUserHybridAuth';

    /**
     * @var string The field to store the user's id.
     */
    public $userIdField = 'user_id';

    /**
     * @var string The field to store the provider name.
     */
    public $providerField = 'provider';

    /**
     * @var string The field to store the user's provider identifier.
     */
    public $identifierField = 'identifier';

    /**
     * @var bool Set to false to send the user an email to activate their account.
     */
    public $activatedAfterSignUp = true;

    /**
     * @var string The route to use in the email when a user requests a new activation email.
     */
    public $resendActivationUrl = 'account/user/resendActivation';

    /**
     * @var string The UserIdentity class you use in your application for logins.
     */
    public $userIdentityClass = 'AccountUserIdentity';

    /**
     * @var string The UserIdentity class you use in your application for hybrid auth logins.
     */
    public $hybridAuthUserIdentityClass = 'AccountHybridAuthUserIdentity';

    /**
     * @var int Default setting for Remember Me checkbox on login page.
     */
    public $rememberDefault = 0;

    /**
     * @var int How long before the Remember Me cookie expires.
     */
    public $rememberDuration = 2592000; // 30 days

    /**
     * @var bool True if we should spool the emails, or false to send immediately.
     */
    public $emailSpool = true;

    /**
     * @var string|array The function that will send the activation email.
     */
    public $emailCallbackActivate = array('AccountEmailManager', 'sendAccountActivate');

    /**
     * @var string|array The function that will send the welcome email.
     */
    public $emailCallbackWelcome = array('AccountEmailManager', 'sendAccountWelcome');

    /**
     * @var string|array The function that will send the lost password email.
     */
    public $emailCallbackLostPassword = array('AccountEmailManager', 'sendAccountLostPassword');

    /**
     * @var bool If we should use reCaptcha.
     */
    public $reCaptcha = true;

    /**
     * @var int The number of login attempts before reCaptcha is used.
     */
    public $reCaptchaLoginCount = 3;

    /**
     * @var string Your public key for recaptcha.
     */
    public $reCaptchaPublicKey = '6LeBItQSAAAAAG_umhiD0vyxXbDFbVMPA0kxZUF6';

    /**
     * @var string Your private key for recaptcha.
     */
    public $reCaptchaPrivateKey = '6LeBItQSAAAAALA4_G05e_-fG5yH_-xqQIN8AfTD';

    /**
     * @var string The server to use for recaptcha requests.
     */
    public $reCaptchaServer = 'http://www.google.com/recaptcha/api';

    /**
     * @var string The server to use for SSL recaptcha requests.
     */
    public $reCaptchaSecureServer = 'https://www.google.com/recaptcha/api';

    /**
     * @var string The server to use to verify recaptcha responses.
     */
    public $reCaptchaVerifyServer = 'www.google.com';

    /**
     * @var array Mapping from controller ID to controller configurations.
     */
    public $controllerMap = array(
        'account' => 'account.controllers.AccountAccountController',
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
     * Refer to Hybrid_Auth docs http://hybridauth.sourceforge.net/userguide.html
     * @var array Hybrid_Auth config
     */
    public $hybridAuthConfig = array(
        'base_url' => '', // url to the hybridAuth action
        'providers' => array(),
    );

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
            $this->_assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('account.assets'));
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
        Yii::import('bootstrap.helpers.*');
        Yii::import('bootstrap.widgets.*');
        Yii::import('bootstrap.behaviors.*');
        Yii::import('bootstrap.form.*');
        Yii::app()->setComponents(array(
            'bootstrap' => array(
                'class' => 'bootstrap.components.TbApi',
            ),
        ), false);
    }

}
