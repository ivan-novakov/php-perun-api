<?php

namespace InoPerunApiTest\Client\Serializer;

use InoPerunApi\Client\Serializer\Json;


class JsonTest extends \PHPUnit_Framework_TestCase
{


    public function testSerialize()
    {
        $data = '{"foo":"bar"}';
        $params = array(
            'foo' => 'bar'
        );
        
        $serializer = $this->getMock('InoPerunApi\Client\Serializer\Json', array(
            'jsonEncode'
        ));
        $serializer->expects($this->once())
            ->method('jsonEncode')
            ->with($params)
            ->will($this->returnValue($data));
        
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        $payload->expects($this->once())
            ->method('getParams')
            ->will($this->returnValue($params));
        
        $expectedData = $serializer->serialize($payload);
    }


    public function testUnserialize()
    {
        $data = '{"foo":"bar"}';
        $params = array(
            'foo' => 'bar'
        );
        
        $serializer = $this->getMock('InoPerunApi\Client\Serializer\Json', array(
            'jsonDecode'
        ));
        $serializer->expects($this->once())
            ->method('jsonDecode')
            ->with($data)
            ->will($this->returnValue($params));
        
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        $payload->expects($this->once())
            ->method('setParams')
            ->with($params);
        
        $expectedPayload = $serializer->unserialize($data, $payload);
        $this->assertSame($expectedPayload, $payload);
    }
}