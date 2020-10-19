<?php

// TODO
// * logger
// * userAgent random
// * proxy

header('Content-Type: application/json');

require_once $_SERVER["DOCUMENT_ROOT"] . '/lib/phpQuery.php';

$answer            = [];
$answer['code']    = 500;
$answer['message'] = 'Unknown error';

$url = $_GET['url'];

if (mb_strlen($url) < 5) {
    $answer['code']    = 500;
    $answer['message'] = 'Empty param';
    echo json_encode($answer);
    exit;
}

function curl_get_contents($url)
{
    $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);
    curl_setopt($ch, CURLOPT_REFERER, 'https://google.com/');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$html = curl_get_contents($url);

if (empty($html)) {
    $answer['code']    = 404;
    $answer['message'] = 'Page not found';
    echo json_encode($answer);
    exit;
}

phpQuery::newDocument($html);
$title = pq('title')->html();
phpQuery::unloadDocuments();

$answer['code']    = 200;
$answer['message'] = 'Sucsess';
$answer['data']    = $title;

echo json_encode($answer);
exit;
