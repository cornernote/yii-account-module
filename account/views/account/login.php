<?php
/**
 * @var $this AccountController
 * @var $user AccountLogin
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

$this->pageTitle = Yii::t('account', 'Login');

/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.widgets.AccountActiveForm', array(
    'id' => 'login-form',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);
echo $form->textFieldControlGroup($user, 'email');
echo $form->passwordFieldControlGroup($user, 'password');
echo $form->checkBoxControlGroup($user, 'rememberMe');

if ($recaptcha) {
    echo CHtml::activeLabel($user, 'recaptcha');
    $this->widget('account.widgets.AccountReCaptchaInput', array('model' => $user));
    echo CHtml::error($user, 'recaptcha');
}
echo $form->endModalWrap();
echo $form->getSubmitButtonRow(Yii::t('account', 'Login'));
$this->endWidget();