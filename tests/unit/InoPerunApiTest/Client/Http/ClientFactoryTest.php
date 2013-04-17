<?php

namespace InoPerunApiTest\Client\Http;

use InoPerunApi\Client\Http\ClientFactory;


class ClientFactoryTest extends \PHPUnit_Framework_TestCase
{


    public function testCreateClient()
    {
        $factory = new ClientFactory();
        $httpClient = $factory->createClient();
        $this->assertInstanceOf('Zend\Http\Client', $httpClient);
    }
}
