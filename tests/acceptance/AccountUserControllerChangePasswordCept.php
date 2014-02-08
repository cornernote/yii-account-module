<?php
/**
 * AccountUserControllerChangePasswordCept Test
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
$I->wantTo('ensure AccountUserController change password works');

// check we are not logged in
$I->amOnPage('/');
$I->see('Hello guest');

// login
$I->amOnPage('/account/user/login');
$I->fillField('AccountLogin_username', 'admin');
$I->fillField('AccountLogin_password', 'admin');
$I->click('Login');
$I->see('You have successfully logged in.');

// change password with empty fields
$I->amOnPage('/account/user/changePassword');
$I->fillField('AccountChangePassword_current_password', '');
$I->fillField('AccountChangePassword_new_password', '');
$I->fillField('AccountChangePassword_confirm_password', '');
$I->click('Save');
$I->see('Please fix the following input errors:');
$I->see('Current Password cannot be blank.');
$I->see('New Password cannot be blank.');
$I->see('Confirm Password cannot be blank.');

// change password with incorrect current password
$I->amOnPage('/account/user/changePassword');
$I->fillField('AccountChangePassword_current_password', 'admin321');
$I->fillField('AccountChangePassword_new_password', 'admin123');
$I->fillField('AccountChangePassword_confirm_password', 'admin123');
$I->click('Save');
$I->see('Please fix the following input errors:');
$I->see('Incorrect password.');

// change password with new password mismatch
$I->amOnPage('/account/user/changePassword');
$I->fillField('AccountChangePassword_current_password', 'admin');
$I->fillField('AccountChangePassword_new_password', 'admin321');
$I->fillField('AccountChangePassword_confirm_password', 'admin123');
$I->click('Save');
$I->see('Please fix the following input errors:');
$I->see('Confirm Password must be repeated exactly.');

// change password with valid data
$I->amOnPage('/account/user/changePassword');
$I->fillField('AccountChangePassword_current_password', 'admin');
$I->fillField('AccountChangePassword_new_password', 'admin123');
$I->fillField('AccountChangePassword_confirm_password', 'admin123');
$I->click('Save');
$I->see('Your password has been saved.');

// logout
$I->amOnPage('/account/user/logout');
$I->see('Your have been logged out.');

// check login
$I->amOnPage('/account/user/login');
$I->fillField('AccountLogin_username', 'admin');
$I->fillField('AccountLogin_password', 'admin123');
$I->click('Login');
$I->see('You have successfully logged in.');
$I->amOnPage('/');
$I->see('Hello admin');

// change password back to admin
$I->amOnPage('/account/user/changePassword');
$I->fillField('AccountChangePassword_current_password', 'admin123');
$I->fillField('AccountChangePassword_new_password', 'admin');
$I->fillField('AccountChangePassword_confirm_password', 'admin');
$I->click('Save');
$I->see('Your password has been saved.');

// logout
$I->amOnPage('/account/user/logout');
$I->see('Your have been logged out.');
