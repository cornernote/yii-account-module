<?php
/**
 * @var $this AccountUserController
 * @var $accountSignUp AccountSignUp
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
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
echo $form->dropDownListControlGroup($accountSignUp, 'timezone', AccountTimezoneHelper::timezones());

echo CHtml::tag('div', array('class' => 'form-actions'), implode(' ', array(
    TbHtml::submitButton(Yii::t('account', 'Sign Up'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::link(Yii::t('account', 'Already have an account?'), array('user/login'), array('class' => 'btn')),
)));
$this->endWidget();

// timezone detection
if (!$accountSignUp->timezone) {
    /** @var AccountModule $account */
    $account = Yii::app()->getModule('account');
    $clientScript = Yii::app()->clientScript;
    $clientScript->registerScriptFile($account->getAssetsUrl() . '/jsTimezoneDetect/jstz.js');
    $clientScript->registerScript('AccountSignUpTimezoneDetect', '$("#AccountSignUp_timezone").val(jstz.determine().name());');
}