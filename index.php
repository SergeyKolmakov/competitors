<?php

require_once '/lib/phpQuery.php';

$url  = $_GET['url'];
$html = file_get_contents($url);

phpQuery::newDocument($html);
$title = pq('title')->html();
phpQuery::unloadDocuments();

echo $title;
