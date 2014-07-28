<?php
/**
 * @var $this AccountUserController
 * @var $accountUser AccountUser
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
$this->pageTitle = Yii::t('account', 'My Account');
?>

<div class="row-fluid">
    <div class="span6">
        <?php
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $attributes = array();
        if ($account->firstNameField)
            $attributes[] = $account->firstNameField;
        if ($account->lastNameField)
            $attributes[] = $account->lastNameField;
        $attributes[] = $account->emailField;
        if ($account->usernameField)
            $attributes[] = $account->usernameField;

        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $accountUser,
            'attributes' => $attributes,
            'htmlOptions' => array('class' => 'table table-condensed'),
        ));

        echo CHtml::tag('div', array('class' => 'form-actions'), implode(' ', array(
            TbHtml::link(Yii::t('account', 'Update Account'), array('account/update'), array('class' => 'btn btn-primary')),
            TbHtml::link(Yii::t('account', 'Change Password'), array('account/password'), array('class' => 'btn')),
            TbHtml::link(Yii::t('account', 'Logout'), array('account/logout'), array('class' => 'btn')),
        )));
        ?>
    </div>
    <div class="span6">
        <h3><?php echo Yii::t('account', 'Link your account to any of the following services:'); ?></h3>

        <div class="well">
            <?php
            $this->widget('account.widgets.HybridAuthWidget', array(
                'baseUrl' => '/account/accountUser/hybridAuth',
            ));
            ?>
        </div>
    </div>
</div>