<?php

$lines = explode("\n", trim(file_get_contents("../config/splashes.txt")));
echo($lines[rand(0, sizeof($lines)-1)]);