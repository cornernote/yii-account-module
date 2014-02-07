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
     * @var string
     */
    public $userClass = 'AccountUser';

    /**
     * @var string
     */
    public $emailField = 'email';

    /**
     * @var string
     */
    public $usernameField = 'username';

    /**
     * Declares the validation rules.
     * @return array
     */
    public function rules()
    {
        $rules = array(
            // email_or_username
            array('email_or_username', 'required'),
            array('email_or_username', 'checkExists'),
        );
        //// recaptcha
        //if (isset(Yii::app()->reCaptcha)) {
        //    $rules[] = array('recaptcha', 'account.validators.AccountReCaptchaValidator', 'on' => 'recaptcha');
        //}
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
            //'recaptcha' => Yii::t('account', 'Enter both words separated by a space'),
        );
    }

    /**
     * Checks if the user exists.
     * This is the 'validateCurrentPassword' validator as declared in rules().
     * @param $attribute
     */
    public function checkExists($attribute)
    {
        $user = CActiveRecord::model($this->userClass)->findByAttributes(array(
            strpos($this->$attribute, '@') || !$this->usernameField ? $this->emailField : $this->usernameField => $this->email_or_username,
        ));
        if (!$user)
            $this->addError($attribute, strpos($this->$attribute, '@') ? Yii::t('account', 'Email is incorrect.') : Yii::t('account', 'Username is incorrect.'));
    }

    public function validate($attributes = null, $clearErrors = true)
    {
        //// enable recaptcha after 3 attempts
        //$attemptKey = 'AccountLostPassword.attempt.' . Yii::app()->request->userHostAddress;
        //$attempts = $app->cache->get($attemptKey);
        //if (!$attempts)
        //    $attempts = 0;
        //$scenario = ($attempts >= 3 && isset($app->reCaptcha)) ? 'recaptcha' : '';

        if (parent::validate($attributes, $clearErrors)) {
            //$app->cache->delete($attemptKey);
            return true;
        }

        //// remove all other errors on recaptcha error
        //if (isset($accountLostPassword->errors['recaptcha'])) {
        //    $errors = $accountLostPassword->errors['recaptcha'];
        //    $accountLostPassword->clearErrors();
        //    foreach ($errors as $error)
        //        $accountLostPassword->addError('recaptcha', $error);
        //}
        //$app->cache->set($attemptKey, ++$attempts);

        return false;
    }

}