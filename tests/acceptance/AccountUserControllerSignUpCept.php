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
$I->wantTo('ensure AccountUserController sign up works');

// check we are not logged in
$I->amOnPage('/');
$I->see('Hello guest');

// check the form is there
$I->amOnPage('/account/user/signUp');
$I->see('First Name');
$I->see('Last Name');
$I->see('Email');
$I->see('Username');
$I->see('Password');
$I->see('Confirm Password');

// signup with empty details
$I->amOnPage('/account/user/signUp');
$I->click('Sign Up');
$I->see('Please fix the following input errors:');
$I->see('Email cannot be blank.');
$I->see('First Name cannot be blank.');
$I->see('Username cannot be blank.');
$I->see('Password cannot be blank.');
$I->see('Confirm Password cannot be blank.');

// signup with invalid email
$I->amOnPage('/account/user/signUp');
$I->fillField('AccountSignUp_first_name', 'demo_first_name');
$I->fillField('AccountSignUp_last_name', 'demo_last_name');
$I->fillField('AccountSignUp_email', 'demo!mailinator.com');
$I->fillField('AccountSignUp_username', 'demo');
$I->fillField('AccountSignUp_password', 'demo123');
$I->fillField('AccountSignUp_confirm_password', 'demo123');
$I->click('Sign Up');
$I->see('Please fix the following input errors:');
$I->dontSee('Email cannot be blank.');
$I->dontSee('First Name cannot be blank.');
$I->dontSee('Username cannot be blank.');
$I->dontSee('Password cannot be blank.');
$I->dontSee('Confirm Password cannot be blank.');
$I->dontSee('Password cannot be blank.');
$I->see('Email is not a valid email address.');

// signup with mismatching password
$I->amOnPage('/account/user/signUp');
$I->fillField('AccountSignUp_first_name', 'demo_first_name');
$I->fillField('AccountSignUp_last_name', 'demo_last_name');
$I->fillField('AccountSignUp_email', 'demo@mailinator.com');
$I->fillField('AccountSignUp_username', 'demo');
$I->fillField('AccountSignUp_password', 'demo123');
$I->fillField('AccountSignUp_confirm_password', 'demo321');
$I->click('Sign Up');
$I->see('Please fix the following input errors:');
$I->dontSee('Email cannot be blank.');
$I->dontSee('First Name cannot be blank.');
$I->dontSee('Username cannot be blank.');
$I->dontSee('Password cannot be blank.');
$I->dontSee('Confirm Password cannot be blank.');
$I->dontSee('Password cannot be blank.');
$I->see('Confirm Password must be repeated exactly.');

// signup with valid details
$I->amOnPage('/account/user/signUp');
$I->fillField('AccountSignUp_first_name', 'demo_first_name');
$I->fillField('AccountSignUp_last_name', 'demo_last_name');
$I->fillField('AccountSignUp_email', 'demo@mailinator.com');
$I->fillField('AccountSignUp_username', 'demo');
$I->fillField('AccountSignUp_password', 'demo123');
$I->fillField('AccountSignUp_confirm_password', 'demo123');
$I->click('Sign Up');
$I->see('Your account has been created and you have been logged in.');
$I->amOnPage('/');
$I->see('Hello demo');

// logout
$I->amOnPage('/account/user/logout');
$I->see('Your have been logged out.');
$I->amOnPage('/');
$I->see('Hello guest');

// login
$I->amOnPage('/account/user/login');
$I->fillField('AccountLogin_username', 'demo');
$I->fillField('AccountLogin_password', 'demo123');
$I->click('Login');
$I->see('You have successfully logged in.');

// check login
$I->amOnPage('/');
$I->see('Hello demo');

// logout
$I->amOnPage('/account/user/logout');
$I->see('Your have been logged out.');

// check guest
$I->amOnPage('/');
$I->see('Hello guest');
