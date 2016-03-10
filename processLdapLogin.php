<?php
require_once "function.php";

//var_dump($_POST);

if (($userInfo = checkldapuser($_POST['login'], $_POST['password'], 'ldap.stuba.sk')) != false) { // IDecko namiesto xcechm4 neberie

    $userInfo = $userInfo[0];

    $arr = [
        'email'     => $userInfo['mail'][3],
        'name'      => $userInfo['givenname'][0],
        'last_name' => $userInfo['sn'][0],
        'uid'       => $userInfo['uid'][0],
        'type'      => 'ldap'
    ];

    if (!User::exists($arr['email'])) {
        if (!User::register($arr)) {
            FlashMessage::putMessage('Problem with first registration', 'error');
        }
    } else {
        User::update($arr);
    }
    User::login($arr['email'], $arr['type']);
    FlashMessage::putMessage('Successfully ldap login', 'success');


    Redirect::to("/");


} else {

    FlashMessage::putMessage('Bad ldap login', 'error');

    Redirect::to("/");

}
