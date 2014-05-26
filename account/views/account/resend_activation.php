<?php
/**
 * @var $this AccountUserController
 * @var $accountResendActivation AccountResendActivation
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */

$this->pageTitle = Yii::t('account', 'Resend Activation');

/** @var AccountModule $account */
$account = Yii::app()->getModule('account');
/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.components.AccountActiveForm', array(
    'id' => 'accountResendActivation-form',
));
echo $form->errorSummary($accountResendActivation);

echo $form->textFieldControlGroup($accountResendActivation, 'email_or_username');

echo CHtml::tag('div', array('class' => 'form-actions'), implode(' ', array(
    TbHtml::submitButton(Yii::t('account', 'Resend Activation'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::link(Yii::t('account', 'Back to login'), array('user/login'), array('class' => 'btn')),
)));
$this->endWidget();
