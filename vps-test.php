<?php
require __DIR__ . '/vendor/autoload.php';
use Ovh\Api;

require __DIR__ . '/parameters.local.php';

$conn = new Api($applicationKey,
    $applicationSecret,
    $endpoint,
    $consumer_key);

$allVps = $conn->get('/vps');
var_dump($allVps);
$servers = [];
foreach ($allVps as $vps) {
    try{
        $query = sprintf('/vps/%s/disks', $vps);
        $disks = $conn->get($query);
        $servers[$vps] = $disks[0];
    } catch (GuzzleHttp\Exception\ClientException $e) {
        
    }
}

$output = __DIR__ . '/var/servers.json';

file_put_contents($output, json_encode($servers));
