<?php
require __DIR__ . '/vendor/autoload.php';
use Ovh\Api;

require __DIR__ . '/parameters.local.php';

$servers = json_decode(file_get_contents('servers.json'));

$conn = new Api($applicationKey,
    $applicationSecret,
    $endpoint,
    $consumer_key);

foreach ($servers as $vps => $disk) {
    $query = sprintf('/vps/%s/disks/%d/use?type=used', $vps, $disk);
    $diskInfo = $conn->get($query);
    $use = $diskInfo['value'] / 10240 *100;
    printf('%s = %d' . PHP_EOL, $vps, $use);
}
