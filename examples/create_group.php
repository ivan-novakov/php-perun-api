<?php
use InoPerunApi\Client\ClientFactory;
use InoPerunApi\Entity\Group;
use InoPerunApi\Manager\GenericManager;

include __DIR__ . '/_common.php';

$config = require __DIR__ . '/_client_config.php';

$clientFactory = new ClientFactory();
$client = $clientFactory->createClient($config);

$groupsManager = new GenericManager($client);
$groupsManager->setManagerName('groupsManager');

$group = new Group();
$group->setName('New test group 5');
$group->setParentGroupId(3141);

try {
    $newGroup = $groupsManager->createGroup(array(
        'vo' => 421,
        'group' => $group
    ), true);
} catch (\Exception $e) {
    _dump("$e");
}

_dump($client->getHttpClient()->getLastRawRequest());
_dump($client->getHttpClient()->getLastRawResponse());
_dump($newGroup);