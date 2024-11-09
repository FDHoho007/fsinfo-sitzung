<?php

require_once("../lib/include.php");
requireRole(ROLE_REDELISTE);

$redmineIndex = json_decode(redmineGet("wiki.json"), true)["wiki_page"]["text"];
$nextSitzung = nextSitzung($redmineIndex);
echo(redmineGet("wiki/$nextSitzung"));