<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/lib/phpQuery.php';

function curl_get_contents($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$url  = $_GET['url'];
$html = curl_get_contents($url);

echo $html;

phpQuery::newDocument($html);
$title = pq('title')->html();
phpQuery::unloadDocuments();

echo $title;
