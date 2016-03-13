<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 13.03.2016
 * Time: 19:01
 */

class MessagesList
{

    private static $messages = [];

    public static function put($message = '', $type = 'error')
    {
        $message = new Message($type, $message);
        self::$messages[] = $message;
    }

    public static function getAll()
    {
        return self::$messages;
    }

    public static function getAllErrors()
    {
        $errors = [];
        foreach (self::$messages as $message) {
            if ($message->getType() == "error") {
                $errors[] = $message;
            }
        }

        return $errors;
    }

    public static function hasMessages()
    {
        if (count(self::$messages) > 0) {
            return true;
        }

        return false;
    }

    public static function hasErrors()
    {
        foreach (self::$messages as $message) {
            if ($message->getType() == "error") {
                return true;
            }
        }

        return false;
    }
}