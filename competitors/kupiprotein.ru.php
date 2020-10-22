<?php

usleep(500000);

$isAvailable = trim(pq("#availability_value")->html()) == 'В наличии';
$price       = intval(pq("#our_price_display")->html());
