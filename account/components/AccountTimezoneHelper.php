<?php

/**
 * AccountTimezoneHelper
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountTimezoneHelper
{

    /**
     * @return array
     */
    public static function timezones()
    {
        $timezones = array('GMT' => 'GMT');
        foreach (DateTimeZone::listIdentifiers(DateTimeZone::ALL) as $timezone) {
            if ($timezones == 'UTC') continue;
            $data[$timezones] = $timezones;
        }
        return $timezones;
    }

    /**
     * @param string $timestamp
     * @param null|string $timeZone
     * @return int|null
     */
    public static function strtotime($timestamp, $timeZone = null)
    {
        $offset = $timeZone ? self::offset($timeZone) : 0;
        if (is_numeric($timestamp))
            return $timestamp + $offset;
        return strtotime($timestamp) + $offset;
    }

    /**
     * @param string $timeZone
     * @return int
     */
    public static function offset($timeZone)
    {
        if (!$timeZone || $timeZone == 'GMT') return 0;
        $dateTimeZone = new DateTimeZone($timeZone);
        $dateTime = new DateTime('now', $dateTimeZone);
        return $dateTimeZone->getOffset($dateTime);
    }

} 