<?php

namespace InoPerunApiTest\Client;

use InoPerunApi\Client\ResponseFactory;


class ResponseFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ResponseFactory
     */
    protected $factory = null;


    public function setUp()
    {
        $this->factory = new ResponseFactory();
    }


    public function testSetPayloadFactory()
    {
        $payloadFactory = $this->createPayloadFactoryMock();
        $this->factory->setPayloadFactory($payloadFactory);
        $this->assertSame($payloadFactory, $this->factory->getPayloadFactory());
    }


    public function testSetSerializer()
    {
        $serializer = $this->getMock('InoPerunApi\Client\Serializer\SerializerInterface');
        $this->factory->setSerializer($serializer);
        $this->assertSame($serializer, $this->factory->getSerializer());
    }


    public function testCreateResponseFromPayload()
    {
        $payload = $this->createPayloadMock();
        $request = $this->createRequestMock();
        
        $response = $this->factory->createResponseFromPayload($payload, $request);
        $this->assertInstanceOf('InoPerunApi\Client\Response', $response);
        $this->assertSame($payload, $response->getPayload());
        $this->assertSame($request, $response->getRequest());
    }


    public function testCreateResponseFromHttpResponseNoSerializer()
    {
        $this->setExpectedException('InoPerunApi\Exception\MissingDependencyException');
        
        $this->factory->createResponseFromHttpResponse($this->createHttpResponseMock(), $this->createRequestMock());
    }


    public function testCreateResponseFromHttpResponse()
    {
        $serializedData = 'serialized data';
        $payload = $this->createPayloadMock();
        $request = $this->createRequestMock();
        $httpResponse = $this->createHttpResponseMock($serializedData);
        
        $this->factory->setSerializer($this->createSerializerMock($serializedData, $payload));
        
        $payloadFactory = $this->createPayloadFactoryMock($payload);
        $this->factory->setPayloadFactory($payloadFactory);
        
        $response = $this->factory->createResponseFromHttpResponse($httpResponse, $request);
        $this->assertSame($payload, $response->getPayload());
        $this->assertSame($request, $response->getRequest());
    }
    
    //----------
    protected function createPayloadFactoryMock($payload = null, $data = null)
    {
        $payloadFactory = $this->getMock('InoPerunApi\Client\PayloadFactory');
        if ($payload) {
            $payloadFactory->expects($this->once())
                ->method('createPayload')
                ->with($data)
                ->will($this->returnValue($payload));
        }
        
        return $payloadFactory;
    }


    protected function createPayloadMock()
    {
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        return $payload;
    }


    protected function createSerializerMock($serializedData, $payload)
    {
        $serializer = $this->getMock('InoPerunApi\Client\Serializer\SerializerInterface');
        $serializer->expects($this->once())
            ->method('unserialize')
            ->with($serializedData)
            ->will($this->returnValue($payload));
        
        return $serializer;
    }


    protected function createRequestMock()
    {
        $request = $this->getMock('InoPerunApi\Client\Request');
        return $request;
    }


    protected function createHttpResponseMock($data = null)
    {
        $httpResponse = $this->getMock('Zend\Http\Response');
        if ($data) {
            $httpResponse->expects($this->once())
                ->method('getBody')
                ->will($this->returnValue($data));
        }
        
        return $httpResponse;
    }
}