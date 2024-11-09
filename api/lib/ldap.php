<?php

function getUsers() {
    $ldap = ldap_connect("ldap://10.30.10.23:1389");
    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    $search = ldap_search($ldap, "ou=users,dc=fsinfo,dc=fim,dc=uni-passau,dc=de", "(&(objectClass=fsinfoPerson)(memberOf=cn=fsinfo,ou=groups,dc=fsinfo,dc=fim,dc=uni-passau,dc=de))", ["uid", "displayName", "cn"]);
    $result = ldap_get_entries($ldap, $search);
    ldap_close($ldap);
    $users = [];
    for($i = 0; $i<$result["count"]; $i++) {
        $users[$result[$i]["uid"][0]] = ["displayName" => $result[$i]["displayname"][0], "fullName" => $result[$i]["cn"][0]];
    }
    return $users;
}