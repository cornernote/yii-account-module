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
 */
$this->pageTitle = Yii::t('account', 'Update Account');

$this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_USER);

/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.widgets.AccountActiveForm', array(
    'id' => 'account-form',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);

echo $form->textFieldControlGroup($user, 'username');
echo $form->textFieldControlGroup($user, 'name');
echo $form->textFieldControlGroup($user, 'email');
echo $form->textFieldControlGroup($user, 'phone');

echo $form->endModalWrap();
echo $form->getSubmitButtonRow(Yii::t('account', 'Save'));
$this->endWidget();
