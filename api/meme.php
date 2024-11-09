<?php

if(!isset($_COOKIE["redeliste_token"])) {
    http_response_code(401);
    return;
}

if($_COOKIE["redeliste_token"] != "AxkJDLx8jZABFmQfEF6XR2rdv3KUXhT6") {
    http_response_code(403);
    return;
}

$meme = "";
if(file_exists("../data/meme.txt")) {
    $meme = file_get_contents("../data/meme.txt");
}

if(isset($_GET["resetcooldown"])) {
    file_put_contents("../data/cooldown.json", "{}");
}
if(isset($_GET["resettoxkcd"])) {
    if(file_exists("../assets/img/$meme")) {
        unlink("../assets/img/$meme");
    }
    file_put_contents("../data/meme.txt", "");
}

if($meme != "" && file_exists("../assets/img/$meme")) {
    $imgUrl = "/assets/img/$meme";
} else {
    $xkcdHTML = file_get_contents("https://xkcd.com");
    preg_match('/\/\/imgs\.xkcd\.com\/[^\s"\'<>]*/', $xkcdHTML, $matches);
    $imgUrl = "https://" . $matches[0];
}
if(str_ends_with($imgUrl, ".mp4")) {
    echo("<div id=\"video-container\"><video id=\"video\" autoplay muted playsinline><source src=\"$imgUrl\" type=\"video/mp4\"></video><script>document.getElementById(\"video\").addEventListener(\"ended\", function() { htmx.ajax(\"GET\", \"/api/meme.php\", {target: \"#video-container\", swap: \"outerHTML\"}); });</script></div>");
} else {
    echo("<div hx-get=\"/api/meme.php\" hx-trigger=\"load delay:1s\" hx-swap=\"outerHTML\"><img src=\"$imgUrl\"></div>");
}