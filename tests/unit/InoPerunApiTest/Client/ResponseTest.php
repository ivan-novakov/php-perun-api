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
        $errorId = 'testid';
        $errorType = 'testtype';
        $errorMessage = 'testmessage';
        
        $request = $this->getRequestMock();
        $payload = $this->getPayloadMock($errorId, $errorType, $errorMessage);
        $response = new Response($request, $payload);
        
        $this->assertTrue($response->isError());
        $this->assertSame($errorId, $response->getErrorId());
        $this->assertSame($errorType, $response->getErrorType());
        $this->assertSame($errorMessage, $response->getErrorMessage());
    }
    
    // ---------------------
    protected function getRequestMock()
    {
        $request = $this->getMockBuilder('InoPerunApi\Client\Request')
            ->disableOriginalConstructor()
            ->getMock();
        
        return $request;
    }


    protected function getPayloadMock($errorId = null, $errorType = null, $errorMessage = null)
    {
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        if ($errorId) {
            $payload->expects($this->at(0))
                ->method('getParam')
                ->with(Response::PARAM_ERROR_ID)
                ->will($this->returnValue($errorId));
            $payload->expects($this->at(1))
                ->method('getParam')
                ->with(Response::PARAM_ERROR_ID)
                ->will($this->returnValue($errorId));
            $payload->expects($this->at(2))
                ->method('getParam')
                ->with(Response::PARAM_ERROR_TYPE)
                ->will($this->returnValue($errorType));
            $payload->expects($this->at(3))
                ->method('getParam')
                ->with(Response::PARAM_ERROR_INFO)
                ->will($this->returnValue($errorMessage));
        }
        
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