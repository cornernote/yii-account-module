<?php
/**
 * AccountAccountControllerSignUp Test
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
$I->wantTo('ensure AccountAccountController reset password works');

// check we are not logged in
$I->amOnPage('/');
$I->see('Hello guest');

// add a token to the database
$I->haveInDatabase('token', array(
    'token' => '$2a$13$lRkdb6kwbIC9aGTkdei2h.NQNlZht9Bpdo2J0PqsJ3tHAFsYJNg7C', // test-token
    'model_name' => 'AccountLostPassword',
    'model_id' => 1,
    'uses_allowed' => 1,
    'uses_remaining' => 1,
    'expires' => strtotime('+1day'),
    'created' => time(),
));

// check with invalid token
$I->amOnPage('/account/account/resetPassword/user_id/1/token/test-invalid-token');
$I->see('Invalid token.');

// reset password with empty details
$I->amOnPage('/account/account/resetPassword/user_id/1/token/test-token');
$I->fillField('AccountResetPassword_new_password', '');
$I->fillField('AccountResetPassword_confirm_password', '');
$I->click('Save Password');
$I->see('Please fix the following input errors:');
$I->see('New Password cannot be blank.');
$I->see('Confirm Password cannot be blank.');

// reset password with password mismatch
$I->amOnPage('/account/account/resetPassword/user_id/1/token/test-token');
$I->fillField('AccountResetPassword_new_password', 'admin123');
$I->fillField('AccountResetPassword_confirm_password', 'admin321');
$I->click('Save Password');
$I->see('Please fix the following input errors:');
$I->see('Confirm Password must be repeated exactly.');

// reset password with correct details
$I->amOnPage('/account/account/resetPassword/user_id/1/token/test-token');
$I->fillField('AccountResetPassword_new_password', 'admin123');
$I->fillField('AccountResetPassword_confirm_password', 'admin123');
$I->click('Save Password');
$I->see('Your password has been saved and you have been logged in.');

// logout
$I->amOnPage('/account/account/logout');
$I->see('Your have been logged out.');

// ensure token is expired
$I->amOnPage('/account/account/resetPassword/user_id/1/token/test-token');
$I->see('Invalid token.');

// check login
$I->amOnPage('/account/account/login');
$I->fillField('AccountLogin_username', 'admin');
$I->fillField('AccountLogin_password', 'admin123');
$I->click('Login');
$I->see('You have successfully logged in.');
$I->amOnPage('/');
$I->see('Hello admin');

// change password back to admin
$I->amOnPage('/account/account/password');
$I->fillField('AccountChangePassword_current_password', 'admin123');
$I->fillField('AccountChangePassword_new_password', 'admin');
$I->fillField('AccountChangePassword_confirm_password', 'admin');
$I->click('Save');
$I->see('Your password has been saved.');

// logout
$I->amOnPage('/account/account/logout');
$I->see('Your have been logged out.');