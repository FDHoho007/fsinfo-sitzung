<?php
function triggerBeamerEvent(string $event): void
{
    $file = fopen("../data/beamer-events.csv", "a");
    fwrite($file, "$event\n");
    fclose($file);
}