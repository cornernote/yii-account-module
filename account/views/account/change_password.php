<?php
/**
 * @var $this AccountController
 * @var $accountChangePassword AccountPassword
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 */
$this->pageTitle = Yii::t('account', 'Change Password');

/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.components.AccountActiveForm', array(
    'id' => 'accountChangePassword-form',
));
echo $form->errorSummary($accountChangePassword);

echo $form->passwordFieldControlGroup($accountChangePassword, 'current_password');
echo $form->passwordFieldControlGroup($accountChangePassword, 'new_password');
echo $form->passwordFieldControlGroup($accountChangePassword, 'confirm_password');

echo $form->getSubmitButtonRow(Yii::t('account', 'Change Password'));
$this->endWidget();