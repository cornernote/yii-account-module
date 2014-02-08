<?php
/**
 * @var $this AccountUserController
 * @var $accountLostPassword AccountLostPassword
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */

$this->pageTitle = Yii::t('account', 'Lost Password');

/** @var AccountModule $account */
$account = Yii::app()->getModule('account');
/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.components.AccountActiveForm', array(
    'id' => 'accountLostPassword-form',
));
echo $form->errorSummary($accountLostPassword);

echo $form->textFieldControlGroup($accountLostPassword, 'email_or_username');

if ($account->reCaptcha) {
    echo CHtml::activeLabel($accountLostPassword, 'captcha');
    $this->widget('account.components.AccountReCaptchaInput', array('model' => $accountLostPassword));
    echo CHtml::error($accountLostPassword, 'captcha');
}

echo CHtml::tag('div', array('class' => 'form-actions'), implode(' ', array(
    TbHtml::submitButton(Yii::t('app', 'Recover Password'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::link(Yii::t('app', 'Login'), array('user/login'), array('class' => 'btn')),
)));
$this->endWidget();
