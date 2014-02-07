<?php

/**
 * Class Yii
 *
 * NOTE: This file is not loaded.
 * It exists so storm links application components correctly.
 */
abstract class Yii extends YiiBase
{
    /**
     * @return Application
     */
    public static function app()
    {
        return parent::app();
    }
} 