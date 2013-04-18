<?php
use InoPerunApi\Client\Http;
use InoPerunApi\Client\Serializer\Json;
use InoPerunApi\Client\Client;
use InoPerunApi\Client\Request;
use InoPerunApi\Client\Authenticator\BasicAuth;
use InoPerunApi\Client\Payload;

include __DIR__ . '/_common.php';

$config = require __DIR__ . '/_client_config.php';

/*
 * HTTP client
 */
$httpClientFactory = new Http\ClientFactory();
$httpClient = $httpClientFactory->createClient($config['http_client']);

/*
 * Serializer
 */
$serializer = new Json();

/*
 * Authenticator
 */
$authenticator = new BasicAuth($config['authenticator']);

/*
 * Perun client
 */
$client = new Client($config['client'], $httpClient, $serializer);
$client->setAuthenticator($authenticator);

/*
 * Perun request
 */
$perunRequest = new Request('usersManager', 'getUserById', new Payload(array(
    'id' => 13793
)));

$perunResponse = $client->send($perunRequest);
_dump($client->getHttpClient()
    ->getLastRawRequest());
_dump($client->getHttpClient()
    ->getLastRawResponse());
_dump($perunResponse);

$perunResponse = $client->sendRequest('usersManager', 'getUserById', array(
    'id' => 13793
));

_dump($perunResponse);