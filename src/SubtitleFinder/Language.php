<?php

namespace SubtitleFinder;

class Language
{
    /**
     * @var array
     */
    public static $languages = array(
        'All' => array('all', ''),
        'Chinese (simplified)' => array('chi', 'zh'),
        'Chinese (traditional)' => array('zht', 'zt'),
        'English' => array('eng', 'en'),
        'Turkish' => array('tur', 'tr')
    );

    /**
     * @return array
     */
    public static function getLanguageNames()
    {
        $names = array_keys(static::$languages);
        sort($names);
        return $names;
    }

    /**
     * @param $name
     * @return string
     */
    public static function getLanguageISO($name)
    {
        return static::$languages[$name][0];
    }

    /**
     * @param $name
     * @return string
     */
    public static function getLanguageISO639($name)
    {
        return static::$languages[$name][1];
    }
}
