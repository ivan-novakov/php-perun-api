<?php
use InoPerunApi\Client\ClientFactory;

include __DIR__ . '/_common.php';

$config = require __DIR__ . '/_client_config.php';

$clientFactory = new ClientFactory();
$client = $clientFactory->createClient($config);

/*
 * $manager = 'usersManager'; $method = 'getUserByExtSourceNameAndExtLogin'; $params = array( 'extSourceName' =>
 * 'https://whoami.cesnet.cz/idp/shibboleth', 'extLogin' => 'novakov@cesnet.cz' ); $changeState = true;
 */

$manager = 'groupsManager';
$method = 'createGroup';
$params = array(
    'vo' => 421,
    'group' => array(
        'name' => 'Test group'
    )
);
$changeState = true;

try {
    $perunResponse = $client->sendRequest($manager, $method, $params, $changeState);
} catch (\Exception $e) {
    _dump("$e");
    // exit();
}

_dump($client->getHttpClient()->getLastRawRequest());
_dump($client->getHttpClient()->getLastRawResponse());
_dump($perunResponse);