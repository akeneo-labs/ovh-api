<?php
require __DIR__ . '/vendor/autoload.php';
use Ovh\Api;

require __DIR__ . '/parameters.local.php';

$conn = new Api($applicationKey,
    $applicationSecret,
    $endpoint,
    $consumer_key);

$allVps = $conn->get('/vps');

$servers = [];
foreach ($allVps as $vps) {
    $query = sprintf('/vps/%s', $vps);
    $infos = $conn->get($query);
    $query = sprintf('/vps/%s/serviceInfos', $vps);
    $infos = array_merge($infos, $conn->get($query));
    $servers[$vps] = $infos;
}

$output = __DIR__ . '/var/vps-infos.json';

file_put_contents($output, json_encode($servers, JSON_PRETTY_PRINT));
