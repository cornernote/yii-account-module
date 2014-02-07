<?php
/**
 * @var $this AccountUserController
 * @var $user User
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

$attributes = array();
if ($this->firstNameField)
    $attributes[] = $this->firstNameField;
if ($this->lastNameField)
    $attributes[] = $this->lastNameField;
$attributes[] = $this->emailField;
if ($this->usernameField)
    $attributes[] = $this->usernameField;

$this->widget('zii.widgets.CDetailView', array(
    'data' => $user,
    'attributes' => $attributes,
));