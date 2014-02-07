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
$this->pageTitle = Yii::t('account', 'Update Account');

/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.components.AccountActiveForm', array(
    'id' => 'account-form',
));
echo $form->errorSummary($user);

echo $form->textFieldControlGroup($user, 'username');
echo $form->textFieldControlGroup($user, 'name');
echo $form->textFieldControlGroup($user, 'email');
echo $form->textFieldControlGroup($user, 'phone');

echo $form->getSubmitButtonRow(Yii::t('account', 'Update Account'));
$this->endWidget();
