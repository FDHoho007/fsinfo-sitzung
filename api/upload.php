<?php

require_once("../lib/include.php");
requireRole(ROLE_USER);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['memeFile'])) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'mp4', 'webm', 'ogg'];
    $fileExtension = pathinfo($_FILES['memeFile']['name'], PATHINFO_EXTENSION);

    if (in_array(strtolower($fileExtension), $allowedExtensions)) {
        uploadMeme($_FILES['memeFile']);
    } else {
        echo "Ungültiges Dateiformat. Bitte laden Sie eine Bild- oder Videodatei hoch.";
    }
}

?>
<!doctype html>
<html lang="de">

<head>

    <?php require_once("../lib/template/meta.php"); ?>

</head>

<body>

<div class="container mt-5">
    <h2 class="mb-4">Meme hochladen</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="memeFile">Meme auswählen</label>
            <input type="file" class="form-control-file" id="memeFile" name="memeFile" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Meme hochladen</button>
    </form>
</div>

</body>

</html>
