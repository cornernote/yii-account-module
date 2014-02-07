<?php

/**
 * AccountLostPassword is the data structure for keeping account lost password form data.
 * It is used by the 'lostPassword' action of 'AccountController'.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package account.models
 */
class AccountLostPassword extends CFormModel
{
    /**
     * @var
     */
    public $username_or_email;

    /**
     * @var
     */
    public $user_id;

    /**
     * @var
     */
    public $recaptcha;

    /**
     * @var string
     */
    public $userClass = 'User';

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     * @return array
     */
    public function rules()
    {
        $rules = array(
            // username_or_email
            array('username_or_email', 'required'),
            array('username_or_email', 'checkExists'),
        );
        // recaptcha
        if (isset(Yii::app()->reCaptcha)) {
            $rules[] = array('recaptcha', 'account.validators.AccountReCaptchaValidator', 'on' => 'recaptcha');
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
            'username_or_email' => Yii::t('account', 'Username or Email'),
            'recaptcha' => Yii::t('account', 'Enter both words separated by a space'),
        );
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function checkExists($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (strpos($this->username_or_email, '@'))
                $user = CActiveRecord::model($this->userClass)->findByAttributes(array('email' => $this->username_or_email));
            else
                $user = CActiveRecord::model($this->userClass)->findByAttributes(array('username' => $this->username_or_email));

            if ($user === null) {
                if (strpos($this->username_or_email, '@'))
                    $this->addError('username_or_email', Yii::t('account', 'Email is incorrect.'));
                else
                    $this->addError('username_or_email', Yii::t('account', 'Username is incorrect.'));
            }
            else {
                $this->user_id = $user->primaryKey;
            }
        }
    }

}
