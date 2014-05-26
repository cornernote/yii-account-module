<?php

/**
 * AccountHybridAuthUserIdentity
 *
 * @property int $id
 * @property Hybrid_Auth $hybridAuth
 * @property Hybrid_Provider_Adapter $hybridProviderAdapter
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountHybridAuthUserIdentity extends AccountUserIdentity
{

    /**
     * @var
     */
    public $provider;

    /**
     * @var int
     */
    private $_id;

    /**
     * @var Hybrid_Auth
     */
    private $_hybridAuth;

    /**
     * @var Hybrid_Provider_Adapter
     */
    private $_hybridProviderAdapter;

    /**
     * Authenticates a user.
     * @throws Exception
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $params = array();
        if (strtolower($this->provider) == 'openid') {
            $params['openid_identifier'] = $_GET['openid_identifier'];
        }

        $this->_hybridProviderAdapter = $this->hybridAuth->authenticate($this->provider, $params);
        if (!$this->_hybridProviderAdapter->isUserConnected()) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        }
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $userHybridAuth = CActiveRecord::model($account->userHybridAuthClass)->findByAttributes(array(
            $account->providerField => $this->provider,
            $account->identifierField => $this->_hybridProviderAdapter->getUserProfile()->identifier,
        ));

        /** @var AccountUser $user */
        $user = $userHybridAuth ? CActiveRecord::model($account->userClass)->findByPk($userHybridAuth->user_id) : false;
        if (!$user) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }
        $this->_id = $user->primaryKey;
        if ($account->activatedField && !$user->{$account->activatedField}) {
            $this->errorCode = self::ERROR_NOT_ACTIVATED;
            return false;
        }
        if ($account->disabledField && $user->{$account->disabledField}) {
            $this->errorCode = self::ERROR_DISABLED;
            return false;
        }
        $this->_id = $user->id;
        $this->_hybridProviderAdapter = $this->_hybridProviderAdapter;
        $this->errorCode = self::ERROR_NONE;
        return true;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return Hybrid_Auth
     */
    public function getHybridAuth()
    {
        if (!$this->_hybridAuth) {
            /** @var AccountModule $account */
            $account = Yii::app()->getModule('account');
            $account->hybridAuthConfig['base_url'] = $account->hybridAuthConfig['baseUrl'] . '?action=callback';
            $this->_hybridAuth = new Hybrid_Auth($account->hybridAuthConfig);
        }
        return $this->_hybridAuth;
    }

    /**
     * @return Hybrid_Provider_Adapter
     */
    public function getHybridProviderAdapter()
    {
        return $this->_hybridProviderAdapter;
    }

}