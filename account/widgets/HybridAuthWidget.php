<?php

/**
 * HybridAuthWidget
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class HybridAuthWidget extends CWidget
{
    /**
     * @var string
     */
    public $baseUrl = '/account/accountUser/hybridAuth';

    /**
     *
     */
    public function run()
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $cs = Yii::app()->getClientScript();
        $assetsUrl = $account->getAssetsUrl() . '/hybridAuth';
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');
        $cs->registerCssFile($cs->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
        $cs->registerScriptFile($assetsUrl . '/script.js');
        $cs->registerCssFile($assetsUrl . '/styles.css');
        $cs->registerCssFile($assetsUrl . '/zocial/css/zocial.css');
        $providers = $account->hybridAuthConfig['providers'];

        echo '<div id="hybridauth-openid-div">';
        echo '<p>' . Yii::t('account', 'Enter your OpenID identity or provider:') . '</p>';
        echo CHtml::beginForm(Yii::app()->createUrl($this->baseUrl, array('returnUrl' => Yii::app()->returnUrl->getLinkValue(true))), 'get', array('id' => 'hybridauth-openid-form'));
        echo CHtml::hiddenField('provider', 'openid');
        echo CHtml::textField('openid_identifier');
        echo CHtml::endForm();
        echo '</div>';

        echo '<div id="hybridauth-confirm-unlink">';
        echo '<p>' . Yii::t('account', 'Are you sure you want to unlink this provider?') . '</p>';
        echo CHtml::beginForm(Yii::app()->createUrl($this->baseUrl, array('action' => 'unlink', 'returnUrl' => Yii::app()->returnUrl->getLinkValue(true))), 'post', array('id' => 'hybridauth-unlink-form'));
        echo CHtml::hiddenField('provider', '', array('id' => 'hybridauth-unlink-provider'));
        echo CHtml::endForm();
        echo '</div>';

        echo '<ul id="hybridauth-provider-list">';
        foreach ($providers as $provider => $settings) {
            if ($settings['enabled'] == true) {
                echo '<li>';
                echo CHtml::link(Yii::t('account', isset($settings['name']) ? $settings['name'] : $provider), array($this->baseUrl, 'provider' => $provider, 'returnUrl' => Yii::app()->returnUrl->getLinkValue(true)), array('id' => 'hybridauth-provider-' . strtolower($provider), 'class' => 'zocial ' . strtolower($provider)));
                echo '</li>';
            }
        }
        echo '</ul>';

        if (!Yii::app()->user->isGuest) {
            $userHybridAuths = CActiveRecord::model($account->userHybridAuthClass)->findAllByAttributes(array($account->userIdField => Yii::app()->user->id));
            if ($userHybridAuths) {
                echo '<h4>' . Yii::t('account', 'Linked Services') . '</h4>';
                echo '<ul id="hybridauth-account-list">';
                /** @var AccountUserHybridAuth[] $userHybridAuths */
                foreach ($userHybridAuths as $userHybridAuth) {
                    $provider = $userHybridAuth->{$account->providerField};
                    echo '<li>';
                    echo CHtml::link($userHybridAuth->{$account->emailField}, 'javascript:void(0);', array('id' => 'hybridauth-account-' . strtolower($provider), 'class' => 'zocial ' . strtolower($provider)));
                    echo '</li>';
                }
                echo '</ul>';
            }
        }

    }
}