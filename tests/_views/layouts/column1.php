<?php
/**
 * @var CController $this
 */
$this->beginContent('tests._views.layouts.main');

$this->widget('bootstrap.widgets.TbNavbar', array(
    'brandLabel' => Yii::app()->name,
    'brandUrl' => Yii::app()->getHomeUrl(),
    'collapse' => true,
    //'items' => SiteMenu::topMenu(),
));
Yii::app()->clientScript->registerCss('header-padding', 'body{ margin-top: 60px; }');
?>
    <div id="body" class="container">
        <?php
        echo Yii::app()->user->multiFlash();
        echo $content;
        ?>
    </div>
<?php
$this->endContent();
?>