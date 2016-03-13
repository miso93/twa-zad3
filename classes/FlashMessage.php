<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 13.03.2016
 * Time: 19:00
 */

class FlashMessage
{

    public static function putMessage($message, $type = 'error')
    {
        $_SESSION['flash'] = ['message' => $message, 'type' => $type];
    }

    public static function getMessage()
    {
        if (isset($_SESSION['flash']) && $_SESSION['flash']) {
            $message = $_SESSION['flash'];
            $_SESSION['flash'] = null;

            return $message;
        }


        return null;
    }
}