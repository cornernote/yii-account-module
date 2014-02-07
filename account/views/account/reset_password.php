<?php
/**
 * @var $this AccountController
 * @var $accountResetPassword AccountResetPassword
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
$this->pageTitle = Yii::t('account', 'Reset Password');

/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.components.AccountActiveForm', array(
    'id' => 'accountResetPassword-form',
));
echo $form->errorSummary($accountResetPassword);

echo $form->passwordFieldControlGroup($accountResetPassword, 'new_password');
echo $form->passwordFieldControlGroup($accountResetPassword, 'confirm_password');

echo $form->getSubmitButtonRow(Yii::t('account', 'Reset Password'));
$this->endWidget();