<?php

namespace InoPerunApiTest\Client;

use InoPerunApi\Client\RequestFactory;


class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RequestFactory
     */
    protected $factory = null;


    public function setUp()
    {
        $this->factory = new RequestFactory();
    }


    public function testSetPayloadFactory()
    {
        $payloadFactory = $this->createPayloadFactoryMock();
        $this->factory->setPayloadFactory($payloadFactory);
        $this->assertSame($payloadFactory, $this->factory->getPayloadFactory());
    }


    public function testCreateRequestWithRawPayload()
    {
        $managerName = 'fooManager';
        $methodName = 'barMethod';
        $changeState = true;
        $payloadData = array(
            'foo' => 'bar'
        );
        $payload = $this->createPayloadMock();
        $payloadFactory = $this->createPayloadFactoryMock($payload, $payloadData);
        $this->factory->setPayloadFactory($payloadFactory);
        
        $request = $this->factory->createRequest($managerName, $methodName, $payloadData, $changeState);
        
        $this->assertSame($managerName, $request->getManagerName());
        $this->assertSame($methodName, $request->getMethodName());
        $this->assertSame($payload, $request->getPayload());
        $this->assertSame($changeState, $request->getChangeState());
    }
    
    //---------------
    protected function createPayloadFactoryMock($payload = null, $payloadData = null)
    {
        $payloadFactory = $this->getMock('InoPerunApi\Client\PayloadFactory');
        if ($payload) {
            $payloadFactory->expects($this->once())
                ->method('createPayload')
                ->with($payloadData)
                ->will($this->returnValue($payload));
        }
        return $payloadFactory;
    }


    protected function createPayloadMock()
    {
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        return $payload;
    }
}