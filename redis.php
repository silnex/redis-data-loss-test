<?php
error_reporting(E_ERROR);

function getRedis()
{
    try {
        $redis = new Redis();
        $redis->connect('redis', 6379);
    } catch (\Throwable $th) {
        header('HTTP/1.1 500 Internal Server Error');
        die;
    }

    return $redis;
}

$redis = getRedis();

if (isset($_GET['reset'])) {
    $redis->set('count', 0);
    echo 'Reset done';
    die;
}

if (isset($_GET['get'])) {
    echo $redis->get('count') ?? 'No value found';
    die;
}

$count = intval($redis->get('count')) ?: 0;

$count = $count + 1;

$redis->set('count', $count, 30);

echo $redis->get('count') ?? 'No value found';
