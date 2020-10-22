<?php

$prices = [];
$blocks = pq('.b-price__normal, .b-price__new');

foreach ($blocks as $block) {
    $prices[] = intval(pq($block)->html());
}

$prices      = array_filter($prices); // remove zero
$isAvailable = !!count($prices);
$isRange     = count($prices) > 1;

if ($isAvailable) {
    $price = array_sum($prices) / count($prices);
    $price = round($price);
}

if ($isAvailable && $isRange) {
    $minPrice = min($prices);
    $maxPrice = max($prices);
}
