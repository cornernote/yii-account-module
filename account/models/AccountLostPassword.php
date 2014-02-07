<?php

/**
 * AccountLostPassword is the data structure for keeping account lost password form data.
 * It is used by the 'lostPassword' action of 'AccountUserController'.
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
class AccountLostPassword extends CFormModel
{
    /**
     * @var
     */
    public $email_or_username;

    /**
     * @var
     */
    public $captcha;

    /**
     * Declares the validation rules.
     * @return array
     */
    public function rules()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $rules = array(
            array('email_or_username', 'required'),
            array('email_or_username', 'checkExists'),
        );
        if ($account->reCaptcha) {
            $rules[] = array('captcha', 'account.validators.AccountReCaptchaValidator');
        }
        return $rules;
    }

    /**
     * Declares attribute labels.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'email_or_username' => Yii::t('account', 'Username or Email'),
            'captcha' => Yii::t('account', 'Enter both words separated by a space'),
        );
    }

    /**
     * Checks if the user exists.
     * This is the 'validateCurrentPassword' validator as declared in rules().
     * @param $attribute
     */
    public function checkExists($attribute)
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $user = CActiveRecord::model($account->userClass)->findByAttributes(array(
            strpos($this->$attribute, '@') || !$account->usernameField ? $account->emailField : $account->usernameField => $this->email_or_username,
        ));
        if (!$user)
            $this->addError($attribute, strpos($this->$attribute, '@') ? Yii::t('account', 'Email is incorrect.') : Yii::t('account', 'Username is incorrect.'));
    }

    /**
     * @param null $attributes
     * @param bool $clearErrors
     * @return bool
     */
    public function validate($attributes = null, $clearErrors = true)
    {
        if (parent::validate($attributes, $clearErrors))
            return true;
        // remove all other errors on captcha error
        if ($errors = $this->getErrors('captcha')) {
            $this->clearErrors();
            foreach ($errors as $error)
                $this->addError('captcha', $error);
        }
        return false;
    }

}