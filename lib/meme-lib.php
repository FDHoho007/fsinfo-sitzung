<?php

function getCurrentXKCD(): string
{
    $xkcdHTML = file_get_contents("https://xkcd.com");
    preg_match('/\/\/imgs\.xkcd\.com\/[^\s"\'<>]*/', $xkcdHTML, $matches);
    return "https:" . $matches[0];
}

function downloadMeme(string $url): void
{
    $urlParts = explode(".", $url);
    $filename = uniqid("meme_", true) . "." . pathinfo($url, PATHINFO_EXTENSION);
    file_put_contents("../meme/$filename", file_get_contents($url));
    file_put_contents("../data/meme.txt", $filename);
    triggerBeamerEvent("reload-meme");
}

function uploadMeme(array $file): void
{
    $filename = uniqid("meme_", true) . "." . pathinfo($file['name'], PATHINFO_EXTENSION);
    move_uploaded_file($file['tmp_name'], "../meme/$filename");
    file_put_contents("../data/meme.txt", $filename);
    triggerBeamerEvent("reload-meme");
}

function getMemeUrl(): string
{
    return "meme/" . file_get_contents("../data/meme.txt");
}

function getMemeCooldown(): array
{
    if (file_exists("../data/cooldown.json")) {
        return json_decode(file_get_contents("../data/cooldown.json"), true);
    }
    return [];
}

function setMemeCooldown(array $cooldown): void
{
    file_put_contents("../data/cooldown.json", json_encode($cooldown));
}