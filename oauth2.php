<?php

require_once "function.php";

$facade = new GoogleFacade();

$client = $facade->getClient();

/************************************************
 * If we have a code back from the OAuth 2.0 flow,
 * we need to exchange that with the authenticate()
 * function. We store the resultant access token
 * bundle in the session, and redirect to ourself.
 ************************************************/
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}
/************************************************
 * If we have an access token, we can make
 * requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
}

/************************************************
 * If we're signed in we can go ahead and retrieve
 * the ID token, which is part of the bundle of
 * data that is exchange in the authenticate step
 * - we only need to do a network call if we have
 * to retrieve the Google certificate to verify it,
 * and that can be cached.
 ************************************************/
if ($client->getAccessToken()) {
    $_SESSION['access_token'] = $client->getAccessToken();
    $token_data = $client->verifyIdToken()->getAttributes();
}

$oauth2 = new Google_Service_Oauth2($client);

$userInfo = $oauth2->userinfo->get();

$arr = [
    'email' => $userInfo->getEmail(),
    'name' => $userInfo->getGivenName(),
    'last_name' => $userInfo->getFamilyName(),
    'google_id' => $userInfo->getId(),
    'picture' => $userInfo->getPicture(),
    'google_profile' => $userInfo->getLink(),
    'type' => 'google'
];

if (!User::exists($arr['email'])) {
    if (!User::register($arr)) {
        FlashMessage::putMessage('Problem with first registration', 'error');
    }
} else {
    User::update($arr);
}
User::login($arr['email'], $arr['type']);
FlashMessage::putMessage('Successfully login by Google OAUTH with email '. $arr['email'], 'success');


Redirect::to("/");