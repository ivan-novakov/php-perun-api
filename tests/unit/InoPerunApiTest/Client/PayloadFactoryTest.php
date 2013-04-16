<?php

namespace InoPerunApiTest\Client;

use InoPerunApi\Client\PayloadFactory;


class PayloadFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PayloadFactory
     */
    protected $factory = null;


    public function setUp()
    {
        $this->factory = new PayloadFactory();
    }


    public function testCreatePayloadWithNull()
    {
        $payload = $this->factory->createPayload(null);
        $this->assertInstanceOf('InoPerunApi\Client\Payload', $payload);
        $this->assertEmpty($payload->getParams());
    }


    public function testCreatePayloadWithArray()
    {
        $data = array(
            'foo' => 'bar'
        );
        $payload = $this->factory->createPayload($data);
        $this->assertInstanceOf('InoPerunApi\Client\Payload', $payload);
        $this->assertSame($data, $payload->getParams());
    }


    public function testCreatePayloadWithInvalidData()
    {
        $this->setExpectedException('InoPerunApi\Client\Exception\InvalidPayloadDataException');
        $payload = $this->factory->createPayload('invalid payload');
    }
}