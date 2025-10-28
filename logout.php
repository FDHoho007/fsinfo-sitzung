<?php

require_once("lib/config.php");
setcookie("sitzung_authentication", "", 0, "/", DOMAIN, true, true);
header("Location: index.php");