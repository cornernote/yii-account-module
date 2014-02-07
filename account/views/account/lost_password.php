<?php
/**
 * @var $this AccountController
 * @var $accountLostPassword AccountLostPassword
 * @var $recaptcha string
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 */

$this->pageTitle = Yii::t('account', 'Lost Password');

/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.components.AccountActiveForm', array(
    'id' => 'accountLostPassword-form',
));
echo $form->errorSummary($accountLostPassword);

echo $form->textFieldControlGroup($accountLostPassword, 'email_or_username');
//if ($accountLostPassword->scenario == 'recaptcha') {
//    echo CHtml::activeLabel($accountLostPassword, 'recaptcha');
//    $this->widget('account.components.AccountReCaptchaInput', array('model' => $accountLostPassword));
//    echo CHtml::error($accountLostPassword, 'recaptcha');
//}

echo $form->getSubmitButtonRow(Yii::t('app', 'Recover Password'));
$this->endWidget();
