<?php

require_once("lib/include.php");
requireLogin();
$role = getRole();

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
            <?php if($role >= ROLE_SITZUNGSLEITUNG) { ?>
            <a href="beamer.php" class="btn btn-primary btn-lg w-100 mb-3">Beameransicht</a>
            <a href="moderate.php" class="btn btn-warning btn-lg w-100 mb-3">Sitzung moderieren</a>
            <?php } if($role >= ROLE_REDELISTE) { ?>
            <a href="redeliste.php" class="btn btn-success btn-lg w-100 mb-3">Redeliste</a>
            <?php } ?>
            <a href="logout.php" class="btn btn-danger btn-lg w-100">Abmelden</a>
        </div>
    </div>
</div>

</body>

</html>
