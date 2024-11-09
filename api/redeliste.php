<?php

require_once("lib/ldap.php");

if(!isset($_COOKIE["redeliste_token"])) {
    http_response_code(401);
    return;
}

if($_COOKIE["redeliste_token"] != "AxkJDLx8jZABFmQfEF6XR2rdv3KUXhT6") {
    http_response_code(403);
    return;
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $redeliste = trim(file_get_contents("../data/redeliste.txt"));
    $redeliste = json_decode($redeliste, true);
    $users = getUsers();
    foreach($redeliste as $col) {
        echo("<div>");
        echo("<h3>" . htmlspecialchars($col["title"]) . "</h3>");
        foreach(explode("\n", $col["content"]) as $line) {
            if(str_starts_with($line, "user:")) {
                echo(htmlspecialchars($users[substr($line, 5)]["displayName"]) . "<br>");
            } else {
                echo(htmlspecialchars($line) . "<br>");
            }
        }
        echo("</div>");
    }
} else if($_SERVER["REQUEST_METHOD"] == "POST") {
    file_put_contents("../data/redeliste.txt", file_get_contents('php://input'));
}