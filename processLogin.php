<?php
require_once "function.php";

if(User::verify($_POST['email'], $_POST['password'])){

    User::login($_POST['email'], 'local');

    FlashMessage::putMessage('Successfully login', 'success');

    Redirect::to("/");

} else {
    FlashMessage::putMessage('Bad login', 'error');

    Redirect::to("/");
}