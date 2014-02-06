<?php
/**
 * @var $this AccountController
 * @var $user User
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 */

$this->pageTitle = Yii::t('account', 'My Account');

$this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_USER);

$this->widget('CDetailView', array(
    'data' => $user,
    'attributes' => array(
        'username',
        'name',
        'email',
        'phone',
    ),
));