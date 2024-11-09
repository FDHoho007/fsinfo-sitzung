<?php

$monthsGermanToEnglish = [
    'Januar' => 'January',
    'Februar' => 'February',
    'März' => 'March',
    'April' => 'April',
    'Mai' => 'May',
    'Juni' => 'June',
    'Juli' => 'July',
    'August' => 'August',
    'September' => 'September',
    'Oktober' => 'October',
    'November' => 'November',
    'Dezember' => 'December'
];

function redmineGet($url, $token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-Redmine-API-Key: $token"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function nextSitzung($index) {
    global $monthsGermanToEnglish;
    preg_match_all('/\d{1,2}\. Sitzung am (\d{1,2}\. [A-Za-z]+ \d{4})/', $index, $matches);
    $sitzungen = [];
    foreach($matches[1] as $key => $date) {
        $date = strtr($date, $monthsGermanToEnglish);
        $date = DateTime::createFromFormat('d. F Y', $date)->getTimestamp();
        $sitzungen[strtotime("midnight", $date)] = $matches[0][$key];
    }
    ksort($sitzungen);
    $now = strtotime("midnight", time());
    foreach($sitzungen as $time => $sitzung) {
        if($time >= $now) {
            $nextSitzung = $sitzung;
            break;
        }
    }
    return str_replace(".", "", str_replace(" ", "_", $nextSitzung));
}