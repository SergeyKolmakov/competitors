<?php

// TODO
// * proxy
// * is price < average - alert!!!
/*
https://xml.yandex.ru/test/
site:fitnessbar.ru/catalog/ |
site:kupiprotein.ru/sportivnoe-pitanie/ |
site:www.fit-health.ru/catalog/ |
site:gold-standart.com |
site:www.brutalshop.ru/products/ |
site:strongline.net/catalog/)
title:(Ultra Women's VPLab 90 капл.) (site:fitnessbar.ru/catalog/ | site:kupiprotein.ru/sportivnoe-pitanie/ | site:www.fit-health.ru/catalog/ | site:gold-standart.com | site:www.brutalshop.ru/products/ | site:spb.kulturist1.ru/catalog/ | site:body-factory.ru/catalog/)
 */

header('Content-Type: application/json');

require_once $_SERVER["DOCUMENT_ROOT"] . '/functions.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/lib/phpQuery.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/config/curl.config.php';

$url  = $_GET['url'];
$host = parse_url($url, PHP_URL_HOST);

$answer            = [];
$answer['code']    = 500;
$answer['message'] = 'Unknown error';
$answer['url']     = $url;

if (mb_strlen($url) < 5 || empty($host)) {
    thowError(500, 'Empty param', $url);
}

$html = curl_get_contents($url, $config);

if (empty($html)) {
    thowError(404, 'Page not found', $url);
}

$handler = $_SERVER["DOCUMENT_ROOT"] . '/competitors/' . $host . '.php';

if (!file_exists($handler)) {
    thowError(500, 'No handler', $url);
}

$title       = 'Error';
$isAvailable = false;
$isRange     = false;
$price       = 9999999;
$minPrice    = 0;
$maxPrice    = 0;

phpQuery::newDocument($html);
$title = pq('title')->html();

// universal - send class name
// if many - range, if single
// parseCompetitor('.card_price--new span');
require_once $handler;

phpQuery::unloadDocuments();

if ($minPrice == $maxPrice) {
    $isRange = false;
}

$answer['code']                = 200;
$answer['message']             = 'Success';
$answer['data']['title']       = $title;
$answer['data']['isAvailable'] = $isAvailable;
$answer['data']['isRange']     = $isRange;
$answer['data']['price']       = $price;
$answer['data']['minPrice']    = $minPrice;
$answer['data']['maxPrice']    = $maxPrice;

if ($isAvailable && ($price == 9999999 or !is_int($price))) {
    thowError(505, 'Parser error. No price', $url);
}

echo json_encode($answer);
exit;
