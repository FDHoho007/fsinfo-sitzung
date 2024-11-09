<?php

require_once("../lib/include.php");
requireRole(ROLE_REDELISTE);
$role = getRole();

header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Connection: keep-alive");
set_time_limit(0);
flush();

$dataFile = "../data/beamer-events.csv";
$lastPosition = filesize($dataFile);

while(true) {
    clearstatcache();
    $fileSize = filesize($dataFile);
    if($fileSize > $lastPosition) {
        $file = fopen($dataFile, "r");
        fseek($file, $lastPosition);
        while($line = fgets($file)) {
            if($role >= ROLE_SITZUNGSLEITUNG || str_starts_with($line, "change-column")) {
                echo("data: $line\n\n");
            }
        }
        flush();
        fclose($file);
        $lastPosition = $fileSize;
    }
    if (connection_aborted()) break;
    sleep(1);
}