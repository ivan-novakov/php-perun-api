<?php
use InoPerunApi\Client\ClientFactory;

include __DIR__ . '/_common.php';

$config = require __DIR__ . '/_client_config.php';

$clientFactory = new ClientFactory();
$client = $clientFactory->createClient($config);

$extLogin = 'novakoi@fel.cvut.cz';
$extSourceName = 'https://login.feld.cvut.cz/idp/shibboleth';
//$extLogin = 'janru@cesnet.cz';
//$extSourceName = 'https://whoami.cesnet.cz/idp/shibboleth';

$user = $client->sendRequest('usersManager', 'getUserByExtSourceNameAndExtLogin', array(
    'extLogin' => $extLogin,
    'extSourceName' => $extSourceName
));

_dump($user);

