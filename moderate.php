<?php

require_once("lib/include.php");
requireRole(ROLE_SITZUNGSLEITUNG);

?>
<!doctype html>
<html lang="de">

<head>

    <?php require_once("lib/template/meta.php"); ?>

</head>

<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h3 class="mb-4">Bitte wähle eine Option</h3>
            <a href="#" onclick="fetch('api/moderate.php?reload-to')" class="btn btn-primary btn-lg w-100 mb-3">Sitzungs TO neu laden</a>
            <a href="#" onclick="fetch('api/moderate.php?reset-meme-cooldown')" class="btn btn-primary btn-lg w-100 mb-3">Meme Cooldown zurücksetzen</a>
            <a href="#" onclick="fetch('api/moderate.php?reset-meme')" class="btn btn-primary btn-lg w-100 mb-3">Meme auf xkcd zurücksetzen</a>
            <a href="index.php" class="btn btn-secondary btn-lg w-100">Zurück</a>
        </div>
    </div>
</div>

</body>

</html>
