<?php
/**
 * @var $this AccountController
 * @var $user User
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 */
$this->pageTitle = Yii::t('account', 'Reset Password');

/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.components.AccountActiveForm', array(
    'id' => 'passwordReset-form',
));
echo $form->errorSummary($user);

echo $form->passwordFieldControlGroup($user, 'new_password');
echo $form->passwordFieldControlGroup($user, 'confirm_password');

echo $form->getSubmitButtonRow(Yii::t('account', 'Reset Password'));
$this->endWidget();