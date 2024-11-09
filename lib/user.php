<?php

function verifyCredentials(string $username, string $password): bool
{
    $ldap = ldap_connect("ldap://10.30.10.23:1389");
    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    return @ldap_bind($ldap, "uid=$username,ou=users,dc=fsinfo,dc=fim,dc=uni-passau,dc=de", $password);
}

function getUsername(): ?string
{
    if (isset($_COOKIE["authentication"]) && JWT::verify($_COOKIE["authentication"])) {
        $jwt = JWT::parse($_COOKIE["authentication"])->getPayload();
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
    setcookie("authentication", $jwt->sign(), $payload["exp"], "/", "sitzung.fs-info.de", true, true);
}

function getRole(): ?int
{
    if (isLoggedIn()) {
        return USERS[getUsername()]["role"];
    }
    return ROLE_USER;
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