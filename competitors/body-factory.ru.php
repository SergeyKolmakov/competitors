<?php

$isAvailable = !!pq(".card_low--empty")->length;
$price       = intval(pq(".card_price--new span")->html());
