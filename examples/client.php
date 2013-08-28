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

if ($perunResponse->isError()) {
    printf("Perun error [%s]: %s (%s)\n", $perunResponse->getErrorId(), $perunResponse->getErrorType(), $perunResponse->getErrorMessage());
}


_dump($client->getHttpClient()
    ->getLastRawRequest());
_dump($client->getHttpClient()
    ->getLastRawResponse());
_dump($perunResponse);

$payload = $perunResponse->getPayload();
_dump($payload->getParam('firstName'));