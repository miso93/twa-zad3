<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 13.03.2016
 * Time: 18:59
 */

class Redirect
{

    public static function to($path)
    {
        header('Location: ' . self::base_url() . $path);
    }

    public static function base_url()
    {
        $base_url = Config::get('app.base_url');

        return $base_url;
    }
}