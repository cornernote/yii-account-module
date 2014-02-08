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

// update details
$I->amOnPage('/account/user/update');

// check login
$I->amOnPage('/');
$I->see('Hello demo');

// logout
$I->amOnPage('/account/user/logout');
$I->see('Your have been logged out.');

// check guest
$I->amOnPage('/');
$I->see('Hello guest');
