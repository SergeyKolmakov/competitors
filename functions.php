<?php

function logger($message, $data = '')
{
    $to      = 's-consul@mail.ru';
    $subject = 'Парсинг Конкурентов';
    $message = $message . '   ' . $data;

    mail($to, $subject, $message);
}

function thowError($code, $message, $data)
{
    $answer            = [];
    $answer['code']    = $code;
    $answer['message'] = $message;
    $answer['url']     = $data;

    logger($message, $data);

    echo json_encode($answer);
    exit;
}

function curl_get_contents($url, $config = [])
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);
    curl_setopt($ch, CURLOPT_REFERER, $config['referer']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
