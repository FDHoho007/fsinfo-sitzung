<?php

function verifyCredentials(string $username, string $password): bool
{
    $ldap = ldap_connect("ldap://" . LDAP_SERVER);
    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    return @ldap_bind($ldap, "uid=$username,ou=users,dc=fsinfo,dc=fim,dc=uni-passau,dc=de", $password);
}

function getUsername(): ?string
{
    if (isset($_COOKIE["sitzung_authentication"]) && JWT::verify($_COOKIE["sitzung_authentication"])) {
        $jwt = JWT::parse($_COOKIE["sitzung_authentication"])->getPayload();
        if ($jwt["iss"] == "fsinfo-sitzung" && $jwt["aud"] == "fsinfo-sitzung" &&
            $jwt["exp"] > time() && $jwt["nbf"] <= time()) {
            return $jwt["sub"];
        }
    }
    return null;
}

function setUsername(string $username): void
{
    $payload = [
        "iss" => "fsinfo-sitzung",
        "aud" => "fsinfo-sitzung",
        "sub" => $username,
        "exp" => time() + SESSION_LIFETIME,
        "nbf" => time(),
        "iat" => time()
    ];
    $jwt = new JWT(JWT::DEFAULT_HEADER, $payload);
    setcookie("sitzung_authentication", $jwt->sign(), $payload["exp"], "/", DOMAIN, true, true);
}

function getRole(): ?int
{
    if (isLoggedIn()) {
        $username = getUsername();
        if(array_key_exists($username, USERS)) {
            return USERS[$username]["role"];
        } else {
            return ROLE_USER;
        }
    }
    return 0;
}

function isLoggedIn(): bool
{
    return getUsername() !== null;
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        redirect("login.php");
    }
}

function requireRole(int $role): void
{
    if (getRole() < $role) {
        redirect("index.php");
    }
}