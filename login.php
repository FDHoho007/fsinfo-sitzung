<?php

require_once("lib/include.php");

if(isset($_POST["username"]) && isset($_POST["password"])) {
    $success = verifyCredentials($_POST["username"], $_POST["password"]);
    if($success) {
        setUsername($_POST["username"]);
        redirect("index.php");
    }
}

?>
<!doctype html>
<html lang="de">

<head>

    <?php require_once("lib/template/meta.php"); ?>

</head>

<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <img src="https://fsinfo.fim.uni-passau.de/images/gruppenfoto_SoSe24.jpg" alt="Logo" class="img-fluid mb-3">
            <h3 class="text-center mb-4">Mit FSinfo Kennung anmelden</h3>
            <?php if(isset($success) && !$success) { ?>
                <div id="errorMessage" class="alert alert-danger">
                    Falscher Benutzername oder falsches Passwort.
                </div>
            <?php } ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Benutzername</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Benutzername eingeben" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Passwort</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Passwort eingeben" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Anmelden</button>
            </form>
        </div>
    </div>
</div>

</body>

</html>
