<?php

require_once("../lib/include.php");

if (!isset($_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN']) || $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] !== TELEGRAM_BOT_SECRET) {
    http_response_code(403);
    exit('Forbidden');
}

const TELEGRAM_API_URL = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN;

$body = json_decode(file_get_contents("php://input"), true);
$cooldown = getMemeCooldown();
if (TELEGRAM_DEBUG) {
    file_put_contents("../data/update.txt", json_encode($body));
}
if (isset($body["message"])) {
    $message = $body["message"];
    $user_id = $message["from"]["id"];
    $message_id = $message["message_id"];
    if (isset($message["text"]) && str_starts_with($message["text"], "/promote")) {
        if (array_key_exists($user_id, $cooldown) && $cooldown[$user_id] > time() - MEME_COOLDOWN) {
            $waitTime = intval((MEME_COOLDOWN - (time() - $cooldown[$user_id])) / 60);
            sendMessage($message["chat"]["id"], "Bitte warte noch $waitTime Minuten bevor du das nächste Meme promotest.", $message_id);
        } else {
            if (isset($message["reply_to_message"])) {
                $reply = $message["reply_to_message"];
                if (isset($reply["photo"])) {
                    $photo = $reply["photo"];
                    $file_id = end($photo)["file_id"];
                } else if (isset($reply["animation"])) {
                    $file_id = $reply["animation"]["file_id"];
                }
            }
            if (isset($file_id)) {
                $file = json_decode(file_get_contents(TELEGRAM_API_URL . "/getFile?file_id=" . $file_id), true);
                if ($file["ok"]) {
                    $cooldown[$user_id] = time();
                    setMemeCooldown($cooldown);
                    $file_url = "https://api.telegram.org/file/bot" . TELEGRAM_BOT_TOKEN . "/" . $file["result"]["file_path"];
                    downloadMeme($file_url);
                }
            } else {
                sendMessage($message["chat"]["id"], "Bitte antworte auf eine Nachricht, die ein Bild enthält, wenn du /promote verwendest.", $message_id);
            }
        }
    }
}

function sendMessage($chat_id, $text, $reply_to_message_id = null): void
{
    $url = TELEGRAM_API_URL . "/sendMessage?chat_id=" . $chat_id . "&text=" . urlencode($text);
    if ($reply_to_message_id != null) {
        $url .= "&reply_to_message_id=" . $reply_to_message_id;
    }
    file_get_contents($url);
}