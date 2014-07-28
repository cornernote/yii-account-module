<?php
/**
 * AccountAccountControllerLogin Test
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
$I->wantTo('ensure AccountAccountController login/logout works');

// check we are not logged in
$I->amOnPage('/');
$I->see('Hello guest');

// check the form is there
$I->amOnPage('/account/account/login');
$I->see('Username');
$I->see('Password');
$I->see('Remember me next time');

// login with empty details
$I->amOnPage('/account/account/login');
$I->click('Login');
$I->see('Please fix the following input errors:');
$I->see('Username cannot be blank.');
$I->see('Password cannot be blank.');

// login with empty password
$I->amOnPage('/account/account/login');
$I->fillField('AccountLogin_username', 'admin');
$I->click('Login');
$I->see('Please fix the following input errors:');
$I->dontSee('Username cannot be blank.');
$I->see('Password cannot be blank.');

// login with empty username
$I->amOnPage('/account/account/login');
$I->fillField('AccountLogin_password', 'admin');
$I->click('Login');
$I->see('Please fix the following input errors:');
$I->see('Username cannot be blank.');
$I->dontSee('Password cannot be blank.');

// login with correct username
$I->amOnPage('/account/account/login');
$I->fillField('AccountLogin_username', 'admin');
$I->fillField('AccountLogin_password', 'admin');
$I->click('Login');
$I->see('You have successfully logged in.');

// check login name
$I->amOnPage('/');
$I->see('Hello admin');

// logout
$I->amOnPage('/account/account/logout');
$I->see('Your have been logged out.');

// login with correct email
$I->amOnPage('/account/account/login');
$I->fillField('AccountLogin_username', 'admin@mailinator.com');
$I->fillField('AccountLogin_password', 'admin');
$I->click('Login');
$I->see('You have successfully logged in.');

// check login name
$I->amOnPage('/');
$I->see('Hello admin');

// logout
$I->amOnPage('/account/account/logout');
$I->see('Your have been logged out.');

// check guest
$I->amOnPage('/');
$I->see('Hello guest');
