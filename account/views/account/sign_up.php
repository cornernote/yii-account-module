<?php
/**
 * @var $this AccountController
 * @var $accountSignUp AccountSignUp
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 */
$this->pageTitle = Yii::t('account', 'Sign Up');

/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.components.AccountActiveForm', array(
    'id' => 'accountSignUp-form',
));
echo $form->errorSummary($accountSignUp);

echo $form->textFieldControlGroup($accountSignUp, 'first_name');
echo $form->textFieldControlGroup($accountSignUp, 'last_name');
echo $form->textFieldControlGroup($accountSignUp, 'email');
echo $form->textFieldControlGroup($accountSignUp, 'username');
echo $form->passwordFieldControlGroup($accountSignUp, 'password');
echo $form->passwordFieldControlGroup($accountSignUp, 'confirm_password');

echo $form->getSubmitButtonRow(Yii::t('account', 'Sign Up'));
$this->endWidget();
