<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 13.03.2016
 * Time: 19:02
 */

class User
{

    private $email = "";
    private $name = "";
    private $last_name = "";
    private $id = null;
    private $google_id = null;
    private $picture = null;
    private $google_profile = null;
    private $has_password = false;

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
            $this->has_password = $user_value->password ? true : false;
        }

    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
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

    public function getPicture()
    {
        return $this->picture;
    }

    public function getGoogleProfile()
    {
        return $this->getGoogleProfile();
    }

    public function hasPassword()
    {
        return $this->has_password;
    }

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
        if(!isset($arr['email'])){
            $user = User::getLoggedUser();
            $arr['email'] = $user->getEmail();
        }
        dibi::query('UPDATE users SET ', $arr, 'WHERE `email`=%s', $arr['email']);
    }

    public static function check()
    {
//        dd($_SESSION);
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