<?php

namespace InoPerunApiTest\Client;

use InoPerunApi\Client\Request;


class RequestTest extends \PHPUnit_Framework_TestCase
{

    protected $request;

    protected $defManagerName = 'defManager';

    protected $defMethodName = 'defMethod';

    protected $defPayload = null;

    protected $defChangeState = false;


    public function setUp()
    {
        $this->defPayload = $this->getMock('InoPerunApi\Client\Payload');
        $this->request = new Request($this->defManagerName, $this->defMethodName, $this->defPayload, $this->defChangeState);
    }


    public function testSetManagerName()
    {
        $this->assertSame($this->defManagerName, $this->request->getManagerName());
        $managerName = 'fooManager';
        $this->request->setManagerName($managerName);
        $this->assertSame($managerName, $this->request->getManagerName());
    }


    public function testSetMethodName()
    {
        $this->assertSame($this->defMethodName, $this->request->getMethodName());
        $methodName = 'fooMethod';
        $this->request->setMethodName($methodName);
        $this->assertSame($methodName, $this->request->getMethodName());
    }


    public function testSetPayload()
    {
        $this->assertSame($this->defPayload, $this->request->getPayload());
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        $this->request->setPayload($payload);
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