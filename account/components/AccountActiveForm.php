<?php
Yii::import('bootstrap.widgets.TbActiveForm');

/**
 * AccountActiveForm
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountActiveForm extends TbActiveForm
{

    /**
     * @param null $label
     * @param array $options
     * @return string
     */
    public function getSubmitButtonRow($label = null, $options = array())
    {
        if (!isset($options['color']))
            $options['color'] = TbHtml::BUTTON_COLOR_PRIMARY;
        return CHtml::tag('div', array('class' => 'form-actions'), TbHtml::submitButton($label, $options));
    }

}