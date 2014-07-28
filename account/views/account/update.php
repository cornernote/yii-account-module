<?php
/**
 * @var $this AccountUserController
 * @var $accountUpdate AccountUpdate
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
$this->pageTitle = Yii::t('account', 'Update Account');

/** @var AccountModule $account */
$account = Yii::app()->getModule('account');

/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.components.AccountActiveForm', array(
    'id' => 'accountUpdate-form',
));
echo $form->errorSummary($accountUpdate);

echo $form->textFieldControlGroup($accountUpdate, 'email', array(
    'label' => CActiveRecord::model($account->userClass)->getAttributeLabel($account->emailField),
));
echo $form->textFieldControlGroup($accountUpdate, 'username', array(
    'label' => CActiveRecord::model($account->userClass)->getAttributeLabel($account->usernameField),
));
if ($account->firstNameField)
    echo $form->textFieldControlGroup($accountUpdate, 'first_name', array(
        'label' => CActiveRecord::model($account->userClass)->getAttributeLabel($account->firstNameField),
    ));
if ($account->lastNameField)
    echo $form->textFieldControlGroup($accountUpdate, 'last_name', array(
        'label' => CActiveRecord::model($account->userClass)->getAttributeLabel($account->lastNameField),
    ));
if ($account->timezoneField)
    echo $form->dropDownListControlGroup($accountUpdate, 'timezone', AccountTimezoneHelper::timezones(), array(
        'label' => CActiveRecord::model($account->userClass)->getAttributeLabel($account->timezoneField),
    ));

echo CHtml::tag('div', array('class' => 'form-actions'), implode(' ', array(
    TbHtml::submitButton(Yii::t('account', 'Save'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::link(Yii::t('account', 'Back'), array('account/view'), array('class' => 'btn')),
)));
$this->endWidget();