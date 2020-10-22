<?php

$price       = pq('meta[itemprop="lowPrice"]')->attr("content");
$isAvailable = !!pq('.count-val')->html();
