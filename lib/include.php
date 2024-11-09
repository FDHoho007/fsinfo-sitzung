<?php

use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

require("config.php");
require("JWT.php");
require("user.php");
require("redmine.php");
require("beamer-lib.php");
require("meme-lib.php");