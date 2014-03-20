<?php

/**
 * AccountWebUserBehavior
 *
 * @property AccountWebUser $owner
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
class AccountWebUserBehavior extends CBehavior
{

    /**
     * Prefix used on flash messages.
     */
    const KEY_PREFIX = 'wuf';

    /**
     * Maximum number of flash messages.
     */
    const STACK_LIMIT = 100;

    /**
     * @var AccountUser
     */
    protected $_user;

    /**
     * Add flash to the stack.
     * @param string $msg
     * @param string $class
     */
    public function addFlash($msg, $class = 'info')
    {
        $key = $this->getNextMultiFlashKey();
        if ($key === false)
            Yii::trace('Stack overflow in addFlash', 'account.components.AccountWebUserFlashBehavior.addFlash()');
        else
            $this->owner->setFlash($key, array($msg, $class));
    }

    /**
     * Returns next flash key for addFlash function.
     * @return string|bool string if ok or false if there was stack overflow.
     */
    protected function getNextMultiFlashKey()
    {
        $counters = $this->owner->getState(CWebUser::FLASH_COUNTERS, array());
        if (empty($counters)) return self::KEY_PREFIX . '1';
        for ($i = 1; $i <= self::STACK_LIMIT; $i++) {
            $key = self::KEY_PREFIX . (string)$i;
            if (array_key_exists($key, $counters)) continue;
            return $key;
        }
        return false;
    }

    /**
     * Gets all flashes and shows them to the user.
     * Every flash is div with css class 'alert' and another 'alert_xxx' where xxx is the $class parameter set in addFlash function.
     * Examples:
     * Yii::app()->user->addFlash('My text', 'warning');
     * Yii::app()->multiFlash();
     * Output is <div class="alert alert-warning">My text<div>
     * @return string
     */
    public function multiFlash()
    {
        $output = '';
        for ($i = 1; $i <= self::STACK_LIMIT; $i++) {
            $key = self::KEY_PREFIX . (string)$i;
            if (!$this->owner->hasFlash($key)) break;
            list($msg, $class) = $this->owner->getFlash($key);
            $output .= "<div class=\"alert alert-$class\">$msg</div>\n";
        }
        return $output;
    }

    /**
     * Load user model
     * @return AccountUser
     */
    public function getUser()
    {
        if (!$this->_user) {
            /** @var AccountModule $account */
            $account = Yii::app()->getModule('account');
            $this->_user = CActiveRecord::model($account->userClass)->findByPk($this->owner->id);
        }
        return $this->_user;
    }

}