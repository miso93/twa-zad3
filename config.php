<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 08.03.2016
 * Time: 21:52
 */

define("ROOT", __DIR__ . "/");

ini_set('display_errors', 'On');
error_reporting(E_ALL);

class Config
{

    private static $config = [
        'mysql' => [
            'db_name' => 'twa-zad3',
            'user'    => 'twa-zad3',
            'pass'    => 's7bXJb7DVeHrWXJX',
            'charset' => 'utf8',
        ]
    ];

    public static function get($key)
    {
        list($first, $second) = explode('.', $key);

        if (isset(self::$config[$first][$second])) {
            return self::$config[$first][$second];
        }

        return null;
    }
}