<?php
/**
 * AccountUserControllerSignUp Test
 *
 * @var $scenario \Codeception\Scenario
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */

$I = new WebGuy($scenario);
$I->wantTo('ensure AccountAccountController lost password works');

// check we are not logged in
$I->amOnPage('/');
$I->see('Hello guest');

// lost password with invalid username
$I->amOnPage('/account/account/lostPassword');
$I->fillField('AccountLostPassword_email_or_username', 'admin123');
$I->click('Recover Password');
$I->see('Please fix the following input errors:');
$I->see('Username is incorrect.');

// lost password with invalid email
$I->amOnPage('/account/account/lostPassword');
$I->fillField('AccountLostPassword_email_or_username', 'admin123@mailinator.com');
$I->click('Recover Password');
$I->see('Please fix the following input errors:');
$I->see('Email is incorrect.');

// lost password with correct username
$I->amOnPage('/account/account/lostPassword');
$I->fillField('AccountLostPassword_email_or_username', 'admin');
$I->click('Recover Password');
$I->see('Password reset instructions have been sent to admin@mailinator.com. Please check your email.');
$I->seeInDatabase('email_spool', array(
    'template' => 'account_lost_password',
    'status' => 'pending',
    'model_name' => 'AccountUser',
    'model_id' => 1,
    'to_address' => '{"admin@mailinator.com":"admin admin"}',
    'from_address' => '{"webmaster@localhost":"My Application"}',
));
$I->seeInDatabase('token', array(
    'model_name' => 'AccountLostPassword',
    'model_id' => 1,
    'uses_allowed' => 1,
    'uses_remaining' => 1,
));

// lost password with correct email
$I->amOnPage('/account/account/lostPassword');
$I->fillField('AccountLostPassword_email_or_username', 'admin@mailinator.com');
$I->click('Recover Password');
$I->see('Password reset instructions have been sent to admin@mailinator.com. Please check your email.');

// check guest
$I->amOnPage('/');
$I->see('Hello guest');
