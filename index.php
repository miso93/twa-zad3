<?php

function checkldapuser($username,$password,$ldap_server){
    if($connect=@ldap_connect($ldap_server)){ // if connected to ldap server

        if (ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3)) {
            echo "version 3<br>\n";
        } else {
            echo "version 2<br>\n";
        }
        echo "verification on '$ldap_server': ";

        // bind to ldap connection
        if(($bind=@ldap_bind($connect)) == false){
            print "bind:__FAILED__<br>\n";
            return false;
        }

        // search for user
        if (($res_id = ldap_search( $connect,
                "dc=stuba, dc=sk",
                "uid=$username")) == false) {
            print "failure: search in LDAP-tree failed<br>";
            return false;
        }

        if (ldap_count_entries($connect, $res_id) != 1) {
            print "failure: username $username found more than once<br>\n";
            return false;
        }

        if (( $entry_id = ldap_first_entry($connect, $res_id))== false) {
            print "failur: entry of searchresult couln't be fetched<br>\n";
            return false;
        }

        if (( $user_dn = ldap_get_dn($connect, $entry_id)) == false) {
            print "failure: user-dn coulnd't be fetched<br>\n";
            return false;
        }

        /* Authentifizierung des User */
        if (($link_id = ldap_bind($connect, $user_dn, $password)) == false) {
            print "failure: username, password didn't match: $user_dn<br>\n";
            return false;
        }

        return true;
        @ldap_close($connect);
    } else {                                  // no conection to ldap server
        echo "no connection to '$ldap_server'<br>\n";
    }

    echo "failed: ".ldap_error($connect)."<BR>\n";

    @ldap_close($connect);
    return(false);

}//end function checkldapuser


if (checkldapuser('xcechm4', 'mojesuperheslo', 'ldap.stuba.sk')) { // IDecko namiesto xcechm4 neberie
    echo "ACCESS GRANTED\n";
} else {
    echo "ACCESS DENIED\n";
}