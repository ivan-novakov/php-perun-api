<?php

namespace InoPerunApiTest\Client;

use InoPerunApi\Client\Response;


class ResponseTest extends \PHPUnit_Framework_TestCase
{


    public function testConstructorNoError()
    {
        $request = $this->getRequestMock();
        $payload = $this->getPayloadMock();
        $response = new Response($request, $payload);
        $this->assertFalse($response->isError());
        $this->assertSame($request, $response->getRequest());
        $this->assertSame($payload, $response->getPayload());
    }


    public function testConstructorWithError()
    {
        $request = $this->getRequestMock();
        $error = $this->getErrorMock();
        $response = new Response($request, null, $error);
        $this->assertTrue($response->isError());
        $this->assertSame($request, $response->getRequest());
        $this->assertSame($error, $response->getError());
    }
    
    // ---------------------
    protected function getRequestMock()
    {
        $request = $this->getMock('InoPerunApi\Client\Request');
        
        return $request;
    }


    protected function getPayloadMock()
    {
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        
        return $payload;
    }


    protected function getErrorMock()
    {
        $error = $this->getMockBuilder('InoPerunApi\Client\Error')
            ->disableOriginalConstructor()
            ->getMock();
        
        return $error;
    }
}