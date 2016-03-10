<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 09.03.2016
 * Time: 10:11
 */
require_once "function.php";

if(User::check()){
    User::logout();

    FlashMessage::putMessage('Logout successfully', 'success');

    Redirect::to("/");
} else {
    FlashMessage::putMessage('You are already logout.', 'error');

    Redirect::to("/");
}