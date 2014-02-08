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
$I->wantTo('ensure AccountUserController update works');

// check we are not logged in
$I->amOnPage('/');
$I->see('Hello guest');

// login
$I->amOnPage('/account/user/login');
$I->fillField('AccountLogin_username', 'admin');
$I->fillField('AccountLogin_password', 'admin');
$I->click('Login');
$I->see('You have successfully logged in.');

// update details with empty fields
$I->amOnPage('/account/user/update');
$I->fillField('AccountUpdate_first_name', '');
$I->fillField('AccountUpdate_last_name', '');
$I->fillField('AccountUpdate_email', '');
$I->fillField('AccountUpdate_username', '');
$I->click('Save');
$I->see('Please fix the following input errors:');
$I->see('Email cannot be blank.');
$I->see('Username cannot be blank.');
$I->see('First Name cannot be blank.');

// update details with invalid email
$I->amOnPage('/account/user/update');
$I->fillField('AccountUpdate_first_name', 'admin-first-name');
$I->fillField('AccountUpdate_last_name', 'admin-last-name');
$I->fillField('AccountUpdate_email', 'admin-email!mailinator.com');
$I->fillField('AccountUpdate_username', 'admin-username');
$I->click('Save');
$I->see('Please fix the following input errors:');
$I->see('Email is not a valid email address.');

// update details with valid data
$I->amOnPage('/account/user/update');
$I->fillField('AccountUpdate_first_name', 'admin-first-name');
$I->fillField('AccountUpdate_last_name', 'admin-last-name');
$I->fillField('AccountUpdate_email', 'admin-email@mailinator.com');
$I->fillField('AccountUpdate_username', 'admin-username');
$I->click('Save');
$I->see('Your account has been updated.');

// check details
$I->amOnPage('/account/user/view');
$I->see('admin-first-name');
$I->see('admin-last-name');
$I->see('admin-email@mailinator.com');
$I->see('admin-username');

// logout
$I->amOnPage('/account/user/logout');
$I->see('Your have been logged out.');

// check login
$I->amOnPage('/account/user/login');
$I->fillField('AccountLogin_username', 'admin-username');
$I->fillField('AccountLogin_password', 'admin');
$I->click('Login');
$I->see('You have successfully logged in.');
$I->amOnPage('/');
$I->see('Hello admin-username');

// logout
$I->amOnPage('/account/user/logout');
$I->see('Your have been logged out.');

// check guest
$I->amOnPage('/');
$I->see('Hello guest');
