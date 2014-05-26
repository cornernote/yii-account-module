<?php

/**
 * AccountHybridAuth is the data structure for keeping hybrid auth account registration form data.
 * It is used by the 'hybridAuth' action of 'AccountUserController'.
 *
 * @property AccountUser $user
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountHybridAuth extends AccountSignUp
{

    /**
     * @var AccountHybridAuthUserIdentity
     */
    public $hybridAuthUserIdentity;

    /**
     * Creates the user.
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');

        // create user
        if (!$this->createUser()) {
            return false;
        }
        // link user
        $this->hybridAuthUserIdentity->id = $this->user->getPrimaryKey();
        if (!$this->linkUser($this->hybridAuthUserIdentity)) {
            return false;
        }
        // return now if activation is required
        if ($account->activatedField && !$account->activatedAfterSignUp) {
            return true;
        }
        // login
        return Yii::app()->user->login($this->hybridAuthUserIdentity);
    }

    /**
     * @param AccountHybridAuthUserIdentity $identity
     * @param int $user_id
     * @return bool
     */
    public function linkUser($identity)
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        /** @var AccountUserHybridAuth $accountUserHybridAuth */
        $accountUserHybridAuth = new $account->userHybridAuthClass;
        $accountUserHybridAuth->{$account->identifierField} = $identity->hybridProviderAdapter->getUserProfile()->identifier;
        $accountUserHybridAuth->{$account->providerField} = $identity->provider;
        $accountUserHybridAuth->{$account->userIdField} = $identity->id;
        $accountUserHybridAuth->{$account->emailField} = $identity->hybridProviderAdapter->getUserProfile()->email;
        return $accountUserHybridAuth->save();
    }

}
