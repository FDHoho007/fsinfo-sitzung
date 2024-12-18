<?php

require_once("lib/include.php");
requireRole(ROLE_SITZUNGSLEITUNG);

?>
<!doctype html>
<html lang="de">

<head>

    <?php require_once("lib/template/meta.php"); ?>
    <link rel="stylesheet" type="text/css" href="assets/beamer.css">
    <script src="assets/beamer.js"></script>

</head>

<body>

<div class="frame-container">
    <iframe src="api/beamer-to.php" class="left-frame" style="zoom: 1.6"></iframe>
    <div class="right-container" style="zoom: 1.3;">
        <div class="top-right-frame container">
            <h1 class="text-center mt-4 fw-bold">Redeliste</h1>
            <div class="row mt-5">
                <div class="col-md-4">
                    <h3 id="title0" class="text-center fw-bold" style="min-height: 35px;"></h3>
                    <div id="content0" class="content-area"></div>
                </div>
                <div class="col-md-4">
                    <h3 id="title1" class="text-center fw-bold" style="min-height: 35px;"></h3>
                    <div id="content1" class="content-area"></div>
                </div>
                <div class="col-md-4">
                    <h3 id="title2" class="text-center fw-bold" style="min-height: 35px;"></h3>
                    <div id="content2" class="content-area"></div>
                </div>
            </div>
        </div>
        <div class="bottom-right-frame container">
            <div id="meme-container"></div>
        </div>
    </div>
</div>

<div id="pause" class="hidden">
    <div>Wir machen eine kleine Pause!</div>
    <div id="pause-countdown"></div>
    <div hx-get="/api/randomsplashtext.php" hx-trigger="every 10s"></div>
    <div id="pause-music" style="display: none;"></div>
</div>

</body>

</html>
