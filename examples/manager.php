<?php
use InoPerunApi\Client\ClientFactory;
use InoPerunApi\Manager\GenericManager;

include __DIR__ . '/_common.php';

$config = require __DIR__ . '/_client_config.php';

$clientFactory = new ClientFactory();
$client = $clientFactory->createClient($config);

$usersManager = new GenericManager($client);
$usersManager->setManagerName('usersManager');

/*
$user = $usersManager->callMethod('getRichUserWithAttributes', array(
    'user' => 13521
));
*/

$user = $usersManager->getRichUserWithAttributes(array(
    'user' => 13521
));

_dump($user);