<?php

namespace InoPerunApiTest\Client;

use InoPerunApi\Client\Request;


class RequestTest extends \PHPUnit_Framework_TestCase
{

    protected $request;


    public function setUp()
    {
        $this->request = new Request();
    }


    public function testSetManagerName()
    {
        $managerName = 'fooManager';
        $this->request->setManagerName($managerName);
        $this->assertSame($managerName, $this->request->getManagerName());
    }


    public function testSetMethodName()
    {
        $methodName = 'fooMethod';
        $this->request->setMethodName($methodName);
        $this->assertSame($methodName, $this->request->getMethodName());
    }


    public function testSetPayloadWithPayload()
    {
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        $this->request->setPayload($payload);
        $this->assertSame($payload, $this->request->getPayload());
    }


    public function testSetPayloadWithArray()
    {
        $params = array(
            'foo' => 'bar'
        );
        
        $this->request->setPayload($params);
        $payload = $this->request->getPayload();
        $this->assertInstanceOf('InoPerunApi\Client\Payload', $payload);
        $this->assertSame($params, $payload->getParams());
    }


    public function testSetPayloadWithNull()
    {
        $this->request->setPayload(null);
        $payload = $this->request->getPayload();
        $this->assertInstanceOf('InoPerunApi\Client\Payload', $payload);
        $this->assertEmpty($payload->getParams());
    }


    public function testSetPayloadWithInvalidPayload()
    {
        $this->setExpectedException('InoPerunApi\Client\Exception\InvalidPayloadException');
        $this->request->setPayload('invalid payload');
    }


    public function testSetChangeState()
    {
        $changeState = true;
        $this->assertFalse($this->request->getChangeState());
        $this->request->setChangeState(true);
        $this->assertTrue($this->request->getChangeState());
        $this->request->setChangeState(false);
        $this->assertFalse($this->request->getChangeState());
    }
}