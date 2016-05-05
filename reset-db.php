<?php

require __DIR__ . '/vendor/autoload.php';

use Jmleroux\VpsTools\Vps;
use Ovh\Api;

require __DIR__ . '/parameters.local.php';

$conn = new Api($applicationKey,
    $applicationSecret,
    $endpoint,
    $consumer_key
);

$serverList = $conn->get('/vps');

$servers = [];
foreach ($serverList as $service) {
    $vps = new Vps($conn, $service);
    $servers[$vps->getService()] = $vps->fetchInfos();
}

$output = __DIR__ . '/var/vps-infos.json';

file_put_contents($output, json_encode($servers, JSON_PRETTY_PRINT));
