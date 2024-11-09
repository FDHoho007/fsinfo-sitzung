<?php

setcookie("authentication", "", 0, "/", "sitzung.fs-info.de", true, true);
header("location: index.php");