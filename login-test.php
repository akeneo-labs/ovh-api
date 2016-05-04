<?php
require __DIR__ . '/vendor/autoload.php';
use Ovh\Api;

require __DIR__ . '/parameters.local.php'

$redirection = "http://google.com";

// Information about API and rights asked
$endpoint = 'ovh-eu';
$rights = [
    (object)[
        'method' => 'GET',
        'path'   => '/vps*'
    ]
];

// Get credentials
$conn = new Api($applicationKey, $applicationSecret, $endpoint);
$credentials = $conn->requestCredentials($rights, $redirection);

// Save consumer key and redirect to authentication page
$consumer_key = $credentials["consumerKey"];

var_dump($credentials["validationUrl"]);

var_dump($consumer_key);
