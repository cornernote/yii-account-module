<?php
/**
 * @var $this AccountWebController
 * @var $content string
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
$this->beginContent('account.views.layouts.main');
?>
    <div class="container-fluid">
        <?php
        if ($this->pageHeading || $this->menu) {
            if ($this->menu)
                $this->pageHeading .= $this->widget('zii.widgets.CMenu', array(
                    'items' => $this->menu,
                    'htmlOptions' => array('class' => 'inline pull-right'),
                ), true);
            echo CHtml::tag('h1', array(), $this->pageHeading);
        }
        ?>
        <div id="content">
            <?php
            echo $content;
            ?>
        </div>
    </div>
<?php
$this->endContent();