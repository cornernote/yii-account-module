<?php

/**
 * AccountHybridAuthAction
 *
 * @property AccountUserController $controller
 * @property array|string $returnUrl
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountHybridAuthAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.sign_up';

    /**
     * @var string
     */
    public $formClass = 'AccountHybridAuth';

    /**
     * @var string|array
     */
    private $_returnUrl;

    /**
     * @param null|string $action
     * @throws Exception
     */
    public function run($action = 'link')
    {
        if ($action == 'link') {
            $this->actionLink();
        }
        if ($action == 'unlink') {
            $this->actionUnlink();
        }
        if ($action == 'callback') {
            $this->actionCallback();
        }
    }

    /**
     * @throws Exception
     */
    public function actionLink()
    {
        if (!isset($_GET['provider'])) {
            throw new Exception('You haven\'t supplied a provider');
        }
        if (!ctype_alpha($_GET['provider'])) {
            throw new Exception('Invalid characters in provider string');
        }

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');

        /** @var AccountHybridAuthUserIdentity $identity */
        $identity = new $account->hybridAuthUserIdentityClass(null, null);
        $identity->provider = $_GET['provider'];

        // valid login
        if ($identity->authenticate()) {
            // hybrid authenticated, and user account exists
            if (Yii::app()->user->isGuest) {
                Yii::app()->user->login($identity, 0);
            }
            $this->controller->redirect($this->returnUrl);
        }

        // account not active
        elseif ($identity->errorCode == AccountUserIdentity::ERROR_NOT_ACTIVATED) {
            $user = CActiveRecord::model($account->userClass)->findByPk($identity->id);
            Yii::app()->user->addFlash(Yii::t('account', 'Your account has not been activated.  <a href=":url">Click here</a> to request a new activation email.', array(':url' => Yii::app()->createUrl($account->resendActivationUrl, array('username' => $user->username)))), 'error');
            $this->controller->redirect($this->returnUrl);
        }

        // account disabled
        elseif ($identity->errorCode == AccountUserIdentity::ERROR_DISABLED) {
            Yii::app()->user->addFlash(Yii::t('account', 'Your account has been disabled.'), 'error');
            $this->controller->redirect($this->returnUrl);
        }

        // user not linked
        else if ($identity->errorCode == $identity::ERROR_USERNAME_INVALID) {
            /** @var AccountHybridAuth $accountHybridAuth */
            $accountHybridAuth = new $this->formClass();
            // already logged in, link account
            if (!Yii::app()->user->isGuest) {
                $identity->id = Yii::app()->user->id;
                $accountHybridAuth->linkUser($identity);
                $this->controller->redirect($this->returnUrl);
            }
            // no user account, create account to link
            else {
                // user posted data
                if (isset($_POST[$this->formClass])) {
                    $accountHybridAuth->attributes = $_POST[$this->formClass];
                    $accountHybridAuth->hybridAuthUserIdentity = $identity;
                    if ($accountHybridAuth->save()) {
                        if (!isset($accountHybridAuth->user->{$account->activatedField}) || $account->activatedAfterSignUp) {
                            Yii::app()->user->addFlash(Yii::t('account', 'Your account has been created and you have been logged in.'), 'success');
                            call_user_func_array($account->emailCallbackWelcome, array($accountHybridAuth->user)); // AccountEmailManager::sendAccountWelcome($accountHybridAuth->user);
                        }
                        else {
                            Yii::app()->user->addFlash(Yii::t('account', 'Your account has been created. Please check your email for activation instructions.'), 'success');
                            call_user_func_array($account->emailCallbackActivate, array($accountHybridAuth->user)); // AccountEmailManager::sendAccountActivate($accountHybridAuth->user);
                        }
                        $this->controller->redirect($this->returnUrl);
                    }
                }
                // no posted data, pre-fill form
                else {
                    Yii::app()->user->addFlash(Yii::t('account', 'Authentication was successful.  Please create an account to continue.'), 'success');
                    $accountHybridAuth->first_name = $identity->hybridProviderAdapter->getUserProfile()->firstName;
                    $accountHybridAuth->last_name = $identity->hybridProviderAdapter->getUserProfile()->lastName;
                    if (!$accountHybridAuth->first_name && !$accountHybridAuth->last_name) {
                        $accountHybridAuth->first_name = $identity->hybridProviderAdapter->getUserProfile()->displayName;
                    }
                    $accountHybridAuth->email = $identity->hybridProviderAdapter->getUserProfile()->email;
                    $accountHybridAuth->username = current(explode('@', $identity->hybridProviderAdapter->getUserProfile()->email));
                }
                $this->controller->render($this->view, array(
                    'accountSignUp' => $accountHybridAuth,
                ));
            }
        }
    }

    /**
     *
     */
    public function actionUnlink()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');

        /** @var AccountUserHybridAuth $userHybridAuth */
        $userHybridAuth = CActiveRecord::model($account->userHybridAuthClass)->findByAttributes(array(
            $account->userIdField => Yii::app()->user->id,
            $account->providerField => $_POST['provider'],
        ));
        if ($userHybridAuth) {
            Yii::app()->user->addFlash(Yii::t('account', 'Authentication has been unlinked from your account.'), 'success');
            $userHybridAuth->delete();
        }
        $this->controller->redirect($this->returnUrl);
    }

    /**
     *
     */
    public function actionCallback()
    {
        Hybrid_Endpoint::process();
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        if (!$this->_returnUrl)
            $this->_returnUrl = Yii::app()->returnUrl->getUrl(Yii::app()->user->returnUrl);
        return $this->_returnUrl;
    }

    /**
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->_returnUrl = $returnUrl;
    }

}