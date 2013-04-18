<?php

use InoPerunApi\Client\ClientFactory;

include __DIR__ . '/_common.php';

$config = require __DIR__ . '/_client_config.php';

$clientFactory = new ClientFactory();
$client = $clientFactory->createClient($config);

try {
    $perunResponse = $client->sendRequest('usersManager', 'getUserById', array(
        'id' => 13793
    ));
} catch (\Exception $e) {
    _dump("$e");
    exit();
}

_dump($client->getHttpClient()
    ->getLastRawRequest());
_dump($client->getHttpClient()
    ->getLastRawResponse());
_dump($perunResponse);

