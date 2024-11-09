<?php

require_once("../lib/redmine.php");

if(!isset($_COOKIE["redmine_token"])) {
    http_response_code(401);
    return;
}

$redmineToken = $_COOKIE["redmine_token"];
$redmineUrl = "https://fsinfo.fim.uni-passau.de/redmine/projects/sitzungen";
$redmineIndex = json_decode(redmineGet("$redmineUrl/wiki.json", $redmineToken), true)["wiki_page"]["text"];
$nextSitzung = nextSitzung($redmineIndex);
echo(redmineGet("$redmineUrl/wiki/$nextSitzung", $redmineToken));
