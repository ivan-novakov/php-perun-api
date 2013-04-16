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


    public function testSetPayloadWithFactoryUse()
    {
        $data = array(
            'foo' => 'bar'
        );
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        $payloadFactory = $this->getMock('InoPerunApi\Client\PayloadFactory');
        $payloadFactory->expects($this->once())
            ->method('createPayload')
            ->with($data)
            ->will($this->returnValue($payload));
        
        $this->request->setPayloadFactory($payloadFactory);
        $this->request->setPayload($data);
        $this->assertSame($payload, $this->request->getPayload());
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