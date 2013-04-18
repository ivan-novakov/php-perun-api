<?php

namespace InoPerunApiTest\Client\Http;

use InoPerunApi\Client\Http\RequestFactory;


class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{

    const SERIALIZER_CODE = 'foo';


    public function testConstructUrl()
    {
        $baseUrl = 'https://example.org/some/path';
        $managerName = 'fooManager';
        $methodName = 'barMethod';
        
        $requestFactory = new RequestFactory($this->createSerializerMock());
        
        $perunRequest = $this->createPerunRequestMock($managerName, $methodName);
        
        $url = $requestFactory->constructUrl($baseUrl, $perunRequest);
        $expectedUrl = sprintf("%s/%s/%s/%s", $baseUrl, self::SERIALIZER_CODE, $managerName, $methodName);
        $this->assertSame($expectedUrl, $url);
    }


    public function testCreateRequestGet()
    {
        $baseUrl = 'https://example.org/some/path';
        $managerName = 'fooManager';
        $methodName = 'barMethod';
        $payloadParams = array(
            'foo' => 'bar'
        );
        $serializedPayload = 'serialized payload';
        $url = 'https://example.org/some/path/foo/bar';
        
        $payload = $this->createPayloadMock($payloadParams);
        
        $perunRequest = $this->createPerunRequestMock($managerName, $methodName, $payload);
        
        $serializer = $this->createSerializerMock();
        
        /* @var $requestFactory \InoPerunApi\Client\Http\RequestFactory */
        $requestFactory = $this->getMock('InoPerunApi\Client\Http\RequestFactory', array(
            'constructUrl'
        ), array(
            $serializer
        ));
        $requestFactory->expects($this->once())
            ->method('constructUrl')
            ->with($baseUrl, $perunRequest)
            ->will($this->returnValue($url));
        
        $httpRequest = $requestFactory->createRequest($baseUrl, $perunRequest);
        $this->assertSame($url, $httpRequest->getUriString());
        $this->assertSame($payloadParams, $httpRequest->getQuery()
            ->toArray());
    }


    public function testCreateRequestPost()
    {
        $baseUrl = 'https://example.org/some/path';
        $managerName = 'fooManager';
        $methodName = 'barMethod';
        $serializedPayload = 'serialized payload';
        $url = 'https://example.org/some/path/foo/bar';
        
        $payload = $this->createPayloadMock(array(
            'foo' => 'bar'
        ));
        
        $perunRequest = $this->createPerunRequestMock($managerName, $methodName, $payload, true);
        
        $serializer = $this->createSerializerMock();
        $serializer->expects($this->once())
            ->method('serialize')
            ->with($payload)
            ->will($this->returnValue($serializedPayload));
        
        /* @var $requestFactory \InoPerunApi\Client\Http\RequestFactory */
        $requestFactory = $this->getMock('InoPerunApi\Client\Http\RequestFactory', array(
            'constructUrl'
        ), array(
            $serializer
        ));
        $requestFactory->expects($this->once())
            ->method('constructUrl')
            ->with($baseUrl, $perunRequest)
            ->will($this->returnValue($url));
        
        $httpRequest = $requestFactory->createRequest($baseUrl, $perunRequest);
        $this->assertSame($url, $httpRequest->getUriString());
        $this->assertSame($serializedPayload, $httpRequest->getContent());
    }
    
    //----------------------
    protected function createSerializerMock()
    {
        $serializer = $this->getMock('InoPerunApi\Client\Serializer\SerializerInterface');
        $serializer->expects($this->any())
            ->method('getCode')
            ->will($this->returnValue(self::SERIALIZER_CODE));
        
        return $serializer;
    }


    protected function createPerunRequestMock($managerName = 'foo', $methodName = 'bar', $payload = array(), $changeState = false)
    {
        $request = $this->getMockBuilder('InoPerunApi\Client\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $request->expects($this->any())
            ->method('getManagerName')
            ->will($this->returnValue($managerName));
        $request->expects($this->any())
            ->method('getMethodName')
            ->will($this->returnValue($methodName));
        $request->expects($this->any())
            ->method('getPayload')
            ->will($this->returnValue($payload));
        $request->expects($this->any())
            ->method('isChangeState')
            ->will($this->returnValue($changeState));
        
        return $request;
    }


    protected function createPayloadMock(array $params = array())
    {
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        $payload->expects($this->any())
            ->method('getParams')
            ->will($this->returnValue($params));
        
        return $payload;
    }
}