<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 08.03.2016
 * Time: 22:07
 */
if (session_id() == "") {
    session_start();
}

require_once "config.php";
require __DIR__ . '/vendor/autoload.php';

dibi::connect([
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'username' => Config::get('mysql.user'),
    'password' => Config::get('mysql.pass'),
    'database' => Config::get('mysql.db_name'),
    'charset'  => Config::get('mysql.charset'),
]);

class Redirect
{

    public static function to($path)
    {
        header('Location: /' . self::base_url() . $path);
    }

    public static function base_url()
    {
        $base_url = basename(__DIR__);

        return $base_url;
    }
}

function dd($arr)
{

    ?>
    <pre>
    <?php
    print_r($arr);
    ?>
</pre>
    <?php
    die();
}

class Message
{

    private $type;
    private $message;

    public function __construct($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getType()
    {
        return $this->type;
    }
}

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

class User
{

    private $email = "";
    private $name = "";
    private $last_name = "";
    private $id = null;
    private $google_id = null;
    private $picture = null;
    private $google_profile = null;

    public function __construct()
    {
        if (User::check()) {
            $result = dibi::query('SELECT * FROM users WHERE email = ?', $_SESSION['login_email']);
            $user_value = $result->fetch();
            $this->id = $user_value->id;
            $this->email = $user_value->email;
            $this->name = $user_value->name;
            $this->last_name = $user_value->last_name;
            $this->google_id = $user_value->google_id;
            $this->picture = $user_value->picture;
            $this->google_profile = $user_value->google_profile;
        }

    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getFullName()
    {
        return $this->getName() . " " . $this->getlastName();
    }

//    public function getLoginType()
//    {
//        return self::$login_type;
//    }

    public static function register($arr)
    {

        if (dibi::query('INSERT INTO users', $arr)) {
            return dibi::getInsertId();
        } else {
            return false;
        }

    }

    public static function exists($email)
    {
        $result = dibi::query('SELECT * FROM users WHERE email = ?', $email);

        $user_value = $result->fetchSingle();
        if ($user_value) {
            return true;
        }

        return false;
    }

    public static function verify($email, $password)
    {
        $result = dibi::query('SELECT * FROM users WHERE email = ?', $email, 'AND password = ?', sha1($password));

        $user_value = $result->fetchSingle();
        if ($user_value) {
            return true;
        }

        return false;
    }

    public static function logout()
    {
        $_SESSION = array();
        session_destroy();
        session_regenerate_id(true);
    }

    public static function login($email, $type)
    {
        $_SESSION['login_email'] = $email;

        $result = dibi::query('SELECT id FROM users WHERE email = ?', $email);

        $user_value = $result->fetchAll();

        $arr = ['login_type' => $type, 'user_id' => $user_value[0]['id']];

        dibi::query('INSERT INTO history_logins', $arr);

    }

    public static function update($arr = array())
    {
        unset($arr['type']);
        dibi::query('UPDATE users SET ', $arr, 'WHERE `email`=%s', $arr['email']);
    }

    public static function check()
    {
        if (isset($_SESSION['login_email']) && $_SESSION['login_email']) {

            return true;
        }
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            return true;
        }

        return false;
    }

    public static function getLoggedUser()
    {
        if (User::check()) {

            $user = new User();

            return $user;
        }

        return null;
    }

    public function getHistory()
    {
        $result = dibi::query('SELECT * FROM history_logins WHERE user_id = ?', $this->id);

        return $result->fetchAll();
    }

    public static function getApplicationHistory()
    {
        $result = dibi::query('SELECT COUNT(*) as count, login_type FROM history_logins GROUP BY login_type');

        return $result->fetchAll();
    }
}

class GoogleFacade
{

    private $client_id = '997320583883-qm9or069sjdo0sfbj917lirvdpsg14qp.apps.googleusercontent.com';
    private $client_secret = 'F39uRKDbsISibZbCQG1JailT';
    private $redirect_uri = 'http://147.175.99.99.nip.io/zad33/oauth2.php';
    private $client;

//    private $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId($this->client_id);
        $this->client->setClientSecret($this->client_secret);
        $this->client->setRedirectUri($this->redirect_uri);
//        $this->client->setScopes();
        $this->client->setScopes(array(
            'email',
            "https://www.googleapis.com/auth/plus.login",
            "https://www.googleapis.com/auth/userinfo.email",
            "https://www.googleapis.com/auth/userinfo.profile",
            "https://www.googleapis.com/auth/plus.me"
        ));
//        $this->client->getClassConfig()
    }

    public function getClient()
    {
        return $this->client;
    }

//    public function getService()
//    {
//        return $this->service;
//    }

}

class ViewData
{

    private static $view_data = [];

    public static function put($key, $data)
    {
        self::$view_data[$key] = $data;
    }

    public static function getAll()
    {
        return self::$view_data;
    }

    public static function get($key)
    {
        if (isset(self::$view_data[$key])) {
            return self::$view_data[$key];
        }

        return null;
    }
}

function checkldapuser($username, $password, $ldap_server)
{
    if ($connect = @ldap_connect($ldap_server)) { // if connected to ldap server

        if (ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3)) {
            echo "version 3<br>\n";
        } else {
            echo "version 2<br>\n";
        }
        echo "verification on '$ldap_server': ";

        // bind to ldap connection
        if (($bind = @ldap_bind($connect)) == false) {
            print "bind:__FAILED__<br>\n";

            return false;
        }

        // search for user
        if (($res_id = ldap_search($connect,
                "dc=stuba, dc=sk",
                "uid=$username")) == false
        ) {
            print "failure: search in LDAP-tree failed<br>";

            return false;
        }

        if (ldap_count_entries($connect, $res_id) != 1) {
            print "failure: username $username found more than once<br>\n";

            return false;
        }

        if (($entry_id = ldap_first_entry($connect, $res_id)) == false) {
            print "failur: entry of searchresult couln't be fetched<br>\n";

            return false;
        }

        if (($user_dn = ldap_get_dn($connect, $entry_id)) == false) {
            print "failure: user-dn coulnd't be fetched<br>\n";

            return false;
        }

        /* Authentifizierung des User */
        if (($link_id = ldap_bind($connect, $user_dn, $password)) == false) {
            print "failure: username, password didn't match: $user_dn<br>\n";

            return false;
        }

        $mail = ldap_get_values($connect, $entry_id, "mail");
        $results = ldap_search($connect, $user_dn, "mail=" . $mail[0], array("givenname", "employeetype", "surname", "mail", "faculty", "cn", "uisid", "uid"));
        $info = ldap_get_entries($connect, $results);

        return $info;
        @ldap_close($connect);
    } else {                                  // no conection to ldap server
        echo "no connection to '$ldap_server'<br>\n";
    }

    echo "failed: " . ldap_error($connect) . "<BR>\n";

    @ldap_close($connect);

    return (false);

}//end function checkldapuser
