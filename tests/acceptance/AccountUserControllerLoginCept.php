<?php
/**
 * AccountUserControllerLogin Test
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
$I->wantTo('ensure AccountUserController login works');

// check the form is there
$I->amOnPage('/account/user/login');
$I->see('Username');
$I->see('Password');
$I->see('Remember me next time');

// login with empty details
$I->amOnPage('/account/user/login');
$I->click('Login');
$I->see('Please fix the following input errors:');
$I->see('Username cannot be blank.');
$I->see('Password cannot be blank.');

// login with empty password
$I->amOnPage('/account/user/login');
$I->fillField('AccountLogin_username', 'admin');
$I->click('Login');
$I->see('Please fix the following input errors:');
$I->dontSee('Username cannot be blank.');
$I->see('Password cannot be blank.');

// login with empty username
$I->amOnPage('/account/user/login');
$I->fillField('AccountLogin_password', 'admin');
$I->click('Login');
$I->see('Please fix the following input errors:');
$I->see('Username cannot be blank.');
$I->dontSee('Password cannot be blank.');

// login with incorrect username
$I->amOnPage('/account/user/login');
$I->fillField('AccountLogin_username', 'admin');
$I->fillField('AccountLogin_password', 'admin');
$I->click('Login');
$I->dontSee('Please fix the following input errors:');
