<?php
require_once "function.php";

$method = $_GET['method'];
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ($method == "registration") {
        require_once "registration.php";
    }
    if ($method == "logout") {
        require_once "processLogout.php";
    }
    if($method == "history") {
        $histories_login = User::getLoggedUser()->getHistory();
        $all_history = User::getApplicationHistory();
        require_once "history_login.php";
    }

} else {
    if ($method == "registration") {
        require_once "processRegistration.php";
    }

    if ($method == "login") {
        require_once "processLogin.php";
    }

    if ($method == "ldap") {
        require_once "processLdapLogin.php";
    }
}

