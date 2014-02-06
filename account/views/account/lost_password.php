<?php
/**
 * @var $this AccountController
 * @var $user AccountLostPassword
 * @var $recaptcha string
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 */

$this->pageTitle = Yii::t('account', 'Lost Password');


/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.widgets.AccountActiveForm', array(
    'id' => 'lostPassword-form',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);

echo $form->textFieldControlGroup($user, 'username_or_email');
if ($recaptcha) {
    echo CHtml::activeLabel($user, 'recaptcha');
    $this->widget('account.widgets.AccountReCaptchaInput', array('model' => $user));
    echo CHtml::error($user, 'recaptcha');
}
echo $form->endModalWrap();
echo $form->getSubmitButtonRow(Yii::t('app', 'Recover Password'));
$this->endWidget();
