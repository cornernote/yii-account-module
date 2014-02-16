<?php
/**
 * AccountUserControllerActivate Test
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
$I->wantTo('ensure AccountUserController activate works');

// check we are not logged in
$I->amOnPage('/');
$I->see('Hello guest');

// add user to the database
$I->haveInDatabase('account_user', array(
    'username' => 'demo-activate',
    'password' => '$2a$13$.m7wlozeIJuRtKp01lR4peYybArVLdO6Pf1JsPSnX6eISL9GXDWBu', // demo-activate
    'first_name' => 'demo-activate',
    'last_name' => 'demo-activate',
    'email' => 'demo-activate@mailinator.com',
    'status' => 0,
));

// add a token to the database
$I->haveInDatabase('token', array(
    'token' => '$2a$13$lRkdb6kwbIC9aGTkdei2h.NQNlZht9Bpdo2J0PqsJ3tHAFsYJNg7C', // test-token
    'model_name' => 'AccountActivate',
    'model_id' => 2,
    'uses_allowed' => 1,
    'uses_remaining' => 1,
    'expires' => strtotime('+1day'),
    'created' => time(),
));

// check with invalid token
$I->amOnPage('/account/user/activate/user_id/2/token/test-invalid-token');
$I->see('Invalid token.');

// reset password with empty details
$I->amOnPage('/account/user/activate/user_id/2/token/test-token');
$I->see('Your account has been activated and you have been logged in.');

// check login
$I->amOnPage('/');
$I->see('Hello demo-activate');

// logout
$I->amOnPage('/account/user/logout');
$I->see('Your have been logged out.');

// ensure token is expired
$I->amOnPage('/account/user/activate/user_id/2/token/test-token');
$I->see('Invalid token.');

// check login
$I->amOnPage('/account/user/login');
$I->fillField('AccountLogin_username', 'demo-activate');
$I->fillField('AccountLogin_password', 'demo-activate');
$I->click('Login');
$I->see('You have successfully logged in.');
$I->amOnPage('/');
$I->see('Hello demo-activate');

// logout
$I->amOnPage('/account/user/logout');
$I->see('Your have been logged out.');