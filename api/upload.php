<?php

require_once("../lib/include.php");
if (!isset($_SERVER['HTTP_X_MAUBOT_API_SECRET'])) {
    requireRole(ROLE_USER);
} else if ($_SERVER['HTTP_X_MAUBOT_API_SECRET'] !== MAUBOT_SECRET) {
    http_response_code(403);
    exit("Wrong maubot api secret. Please contact the administrator.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['memeFile'])) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'mp4', 'webm', 'ogg'];
    $fileExtension = pathinfo($_FILES['memeFile']['name'], PATHINFO_EXTENSION);

    if (in_array(strtolower($fileExtension), $allowedExtensions)) {
        if(isset($_SERVER['HTTP_X_MAUBOT_API_SECRET']) && isset($_SERVER['HTTP_X_MATRIX_USER'])) {
            $cooldown = getMemeCooldown();
            $user_id = $_SERVER['HTTP_X_MATRIX_USER'];
            if (array_key_exists($user_id, $cooldown) && $cooldown[$user_id] > time() - MEME_COOLDOWN) {
                $waitTime = intval((MEME_COOLDOWN - (time() - $cooldown[$user_id])) / 60);
                http_response_code(429);
                echo("Please wait $waitTime minutes before promoting another meme.");
                exit;
            }
            $cooldown[$user_id] = time();
            setMemeCooldown($cooldown);
        }
        uploadMeme($_FILES['memeFile']);
        if(isset($_SERVER['HTTP_X_MAUBOT_API_SECRET'])) {
            exit; // Every response != 200 will be sent back to chat. Therefore maubot should abort here.
        }
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
