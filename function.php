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
require_once __DIR__ . '/classes_load.php';

dibi::connect([
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'username' => Config::get('mysql.user'),
    'password' => Config::get('mysql.pass'),
    'database' => Config::get('mysql.db_name'),
    'charset'  => Config::get('mysql.charset'),
]);


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
