<?php

define("TELEGRAM_BOT_TOKEN", "<REDACTED>");
define("TELEGRAM_API_URL", "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN);
define("PROMOTE_COOLDOWN", 5*60);

$update = json_decode(file_get_contents("php://input"), true);
$cooldown = [];
if(file_exists("../data/cooldown.json")) {
    $cooldown = json_decode(file_get_contents("../data/cooldown.json"), true);
}
file_put_contents("../data/update.txt", json_encode($update));
if(isset($update["message"])) {
    $message = $update["message"];
    $user_id = $message["from"]["id"];
    $message_id = $message["message_id"];
    if (isset($message["text"]) && str_starts_with($message["text"], "/promote")) {
        if (array_key_exists($user_id, $cooldown) && $cooldown[$user_id] > time() - PROMOTE_COOLDOWN) {
            sendMessage($message["chat"]["id"], "Bitte warte noch " . intval((PROMOTE_COOLDOWN - (time() - $cooldown[$user_id]))/60) . " Minuten bevor du das nächste Meme promotest.", $message_id);
        } else {
            if (isset($message["reply_to_message"])) {
                if(isset($message["reply_to_message"]["photo"])) {
                    $photo = $message["reply_to_message"]["photo"];
                    $file_id = end($photo)["file_id"];
                } else if(isset($message["reply_to_message"]["animation"])) {
                    $file_id = $message["reply_to_message"]["animation"]["file_id"];
                }
                if(isset($file_id)) {
                    $file = json_decode(file_get_contents(TELEGRAM_API_URL . "/getFile?file_id=" . $file_id), true);
                    if ($file["ok"]) {
                        $cooldown[$user_id] = time();
                        file_put_contents("../data/cooldown.json", json_encode($cooldown));
                        $file_path = $file["result"]["file_path"];
                        $file_url = "https://api.telegram.org/file/bot" . TELEGRAM_BOT_TOKEN . "/" . $file_path;
                        file_put_contents("../data/img-link.txt", $file_url);
                        $filename = uniqid("img_", true) . "." . end(explode(".", $file_url));
                        file_put_contents("../assets/img/$filename", file_get_contents($file_url));
                        $oldMeme = file_get_contents("../data/meme.txt");
                        file_put_contents("../data/meme.txt", $filename);
                        if($oldMeme != "" && file_exists("../assets/img/$oldMeme")) {
                            unlink("../assets/img/$oldMeme");
                        }
                    }
                } else {
                    sendMessage($message["chat"]["id"], "Bitte antworte auf eine Nachricht, die ein Bild enthält, wenn du /promote verwendest.", $message_id);
                }
            } else {
                sendMessage($message["chat"]["id"], "Bitte antworte auf eine Nachricht, die ein Bild enthält, wenn du /promote verwendest.", $message_id);
            }
        }
    }
}

function sendMessage($chat_id, $text, $reply_to_message_id = null) {
    $url = TELEGRAM_API_URL . "/sendMessage?chat_id=" . $chat_id . "&text=" . urlencode($text);
    if ($reply_to_message_id != null) {
        $url .= "&reply_to_message_id=" . $reply_to_message_id;
    }
    file_get_contents($url);
}