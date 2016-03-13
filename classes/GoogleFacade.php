<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 13.03.2016
 * Time: 19:05
 */

class GoogleFacade
{

    private $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(Config::get('google.client_id'));
        $this->client->setClientSecret(Config::get('google.client_secret'));
        $this->client->setRedirectUri(Config::get('google.redirect_uri'));

        $this->client->setScopes(array(
            'email',
            "https://www.googleapis.com/auth/plus.login",
            "https://www.googleapis.com/auth/userinfo.email",
            "https://www.googleapis.com/auth/userinfo.profile",
            "https://www.googleapis.com/auth/plus.me"
        ));
    }

    public function getClient()
    {
        return $this->client;
    }

}