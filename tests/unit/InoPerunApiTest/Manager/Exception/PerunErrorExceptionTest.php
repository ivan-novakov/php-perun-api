<?php

namespace InoPerunApiTest\Manager\Exception;

use InoPerunApi\Manager\Exception\PerunErrorException;


class PerunErrorExceptionTest extends \PHPUnit_Framework_TestCase
{


    public function testCreateFromResponse()
    {
        $errorId = 123;
        
        $response = $this->getResponseMock();
        $response->expects($this->once())
            ->method('getErrorId')
            ->will($this->returnValue($errorId));
        
        $e = PerunErrorException::createFromResponse($response);
        
        $this->assertInstanceOf('InoPerunApi\Manager\Exception\PerunErrorException', $e);
        $this->assertSame($errorId, $e->getErrorId());
    }
    
    /*
     * 
     */
    protected function getResponseMock()
    {
        $response = $this->getMockBuilder('InoPerunApi\Client\Response')
            ->disableOriginalConstructor()
            ->getMock();
        return $response;
    }
}