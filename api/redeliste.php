<?php

require_once('../lib/include.php');
requireRole(ROLE_REDELISTE);

if(isset($_GET["to"])) {
    triggerBeamerEvent("set-to," . $_GET["to"]);
} else if(isset($_GET["column"])) {
    $allowedTags = "<b><i><u><strong><em><br><p><ul><ol><li><div><span><style>";
    $column = $_GET["column"];
    $dataFile = "../data/redeliste.json";
    if(!file_exists($dataFile)) {
        $empty = [
            "column0" => ["title" => "", "content" => ""],
            "column1" => ["title" => "", "content" => ""],
            "column2" => ["title" => "", "content" => ""]
        ];
        file_put_contents($dataFile, json_encode($empty));
    }
    $data = json_decode(file_get_contents($dataFile), true);
    if(isset($_POST["title"])) {
        $data["column$column"]["title"] = strip_tags($_POST["title"], $allowedTags);
        file_put_contents($dataFile, json_encode($data));
        triggerBeamerEvent("update-column,$column");
    } else if(isset($_POST["content"])) {
        $data["column$column"]["content"] = strip_tags($_POST["content"], $allowedTags);
        file_put_contents($dataFile, json_encode($data));
        triggerBeamerEvent("update-column,$column");
    } else {
        echo(json_encode($data["column$column"]));
    }
}