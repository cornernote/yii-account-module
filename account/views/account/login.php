<?php
/**
 * @var $this AccountUserController
 * @var $accountLogin AccountLogin
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */

$this->pageTitle = Yii::t('account', 'Login');
?>

<div class="row-fluid">
    <div class="span6">
        <?php
        /** @var AccountActiveForm $form */
        $form = $this->beginWidget('account.components.AccountActiveForm', array(
            'id' => 'accountLogin-form',
        ));
        echo $form->errorSummary($accountLogin);
        echo $form->textFieldControlGroup($accountLogin, 'username');
        echo $form->passwordFieldControlGroup($accountLogin, 'password');
        echo $form->checkBoxControlGroup($accountLogin, 'remember');
        if ($accountLogin->isCaptchaRequired()) {
            echo CHtml::activeLabel($accountLogin, 'captcha');
            $this->widget('account.components.AccountReCaptchaInput', array('model' => $accountLogin));
            echo CHtml::error($accountLogin, 'captcha');
        }
        echo CHtml::tag('div', array('class' => 'form-actions'), implode(' ', array(
            TbHtml::submitButton(Yii::t('account', 'Login'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
            TbHtml::link(Yii::t('account', 'Sign up'), array('account/signUp'), array('class' => 'btn')),
            TbHtml::link(Yii::t('account', 'Lost password?'), array('account/lostPassword'), array('class' => 'btn')),
        )));
        $this->endWidget();
        ?>
    </div>
    <div class="span6">
        <h3><?php echo Yii::t('account', 'Log in using any of the following services:'); ?></h3>

        <div class="well">
            <?php
            $this->widget('account.widgets.HybridAuthWidget', array(
                'baseUrl' => '/account/accountUser/hybridAuth',
            ));
            ?>
        </div>
    </div>
</div>