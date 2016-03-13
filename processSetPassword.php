<?php

if(User::check()){

    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if($password != $password_confirm){

        FlashMessage::putMessage('Password isn\'t match.');
        Redirect::to('/');
    }

    $user = User::getLoggedUser();

    $arr = [
        'password' => sha1($password)
    ];
    $user->update($arr);

    Redirect::to('/');

} else {

    Redirect::to('/');
}
