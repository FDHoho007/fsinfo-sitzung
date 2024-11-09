<?php

require_once("lib/include.php");
requireRole(ROLE_REDELISTE);

?>
<!doctype html>
<html lang="de">

<head>

    <?php require_once("lib/template/meta.php"); ?>

</head>

<body>

<div class="container mt-5">
    <h1 class="text-center">Redeliste verwalten</h1>

    <form id="change-to" class="mt-4">
        <div class="row g-3 align-items-center justify-content-center">
            <div class="col-auto">
                <select id="current-to" class="form-select">
                    <option value="null">kein TO Punkt ausgewählt</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">TO Punkt ändern</button>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-warning" id="next-to">Nächster TO Punkt</button>
            </div>
        </div>
    </form>

    <div class="row mt-5">
        <div class="col-md-4">
            <h5 class="text-center">Spalte 1</h5>
            <input id="title0" type="text" class="form-control mb-2" placeholder="Spaltenüberschrift" oninput="updateTitle(0, this.value)">
            <textarea id="content0" class="form-control" rows="15" placeholder="Inhalt einfügen" oninput="updateContent(0, this.value)"></textarea>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Spalte 2</h5>
            <input id="title1" type="text" class="form-control mb-2" placeholder="Spaltenüberschrift" oninput="updateTitle(1, this.value)">
            <textarea id="content1" class="form-control" rows="15" placeholder="Inhalt einfügen" oninput="updateContent(1, this.value)"></textarea>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Spalte 3</h5>
            <input id="title2" type="text" class="form-control mb-2" placeholder="Spaltenüberschrift" oninput="updateTitle(2, this.value)">
            <textarea id="content2" class="form-control" rows="15" placeholder="Inhalt einfügen" oninput="updateContent(2, this.value)"></textarea>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary ms-2">Zurück</a>
    </div>
</div>

<script type="text/javascript" src="assets/redeliste.js"></script>

</body>

</html>
