<?php

require_once('../lib/include.php');
requireRole(ROLE_SITZUNGSLEITUNG);

if(isset($_GET["reload-to"])) {
    triggerBeamerEvent("reload-to");
} else if(isset($_GET["reset-meme-cooldown"])) {
    setMemeCooldown([]);
} else if(isset($_GET["reset-meme"])) {
    downloadMeme(getCurrentXKCD());
}