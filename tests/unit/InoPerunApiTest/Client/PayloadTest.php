<?php

namespace InoPerunApiTest\Client;

use InoPerunApi\Client\Payload;


class PayloadTest extends \PHPUnit_Framework_TestCase
{


    public function testConstructor()
    {
        $params = array(
            'foo' => 'bar'
        );
        $payload = new Payload($params);
        $this->assertSame($params, $payload->getParams());
    }


    public function testSetParams()
    {
        $params = array(
            'foo' => 'bar'
        );
        $payload = new Payload();
        $this->assertSame(array(), $payload->getParams());
        $payload->setParams($params);
        $this->assertSame($params, $payload->getParams());
    }


    public function testSetParam()
    {
        $payload = new Payload();
        $this->assertNull($payload->getParam('foo'));
        $payload->setParam('foo', 'bar');
        $this->assertSame('bar', $payload->getParam('foo'));
    }
}