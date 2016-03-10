<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 08.03.2016
 * Time: 22:34
 */


require_once "function.php";

$arr = [
    'email' => $_POST['email'],
    'password' => array('SHA1(?)', $_POST['password']),
    'name' => $_POST['name'],
    'last_name' => $_POST['last_name'],
    'type' => 'local'
];
if (!User::exists($arr['email'])) {
    if(User::register($arr)){
        FlashMessage::putMessage('Registration successfully', 'success');

        Redirect::to("/");
    } else {
        FlashMessage::putMessage('Registration failed', 'error');

        Redirect::to("/");
    }
} else {
    FlashMessage::putMessage('Registration failed, email is already used', 'error');

    Redirect::to("/");
}


