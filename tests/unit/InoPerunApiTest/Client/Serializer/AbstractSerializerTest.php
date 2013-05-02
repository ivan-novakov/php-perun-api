<?php

namespace InoPerunApiTest\Client\Serializer;


class AbstractSerializerTest extends \PHPUnit_Framework_TestCase
{

    public function testSetCode()
    {
        $serializer = $this->createSerializerMock();
        $code = 'test';
        $serializer->setCode($code);
        $this->assertSame($code, $serializer->getCode());
    }

    public function testSetMimeType()
    {
        $serializer = $this->createSerializerMock();
        $mimeType = 'foo/bar';
        $serializer->setMimeType($mimeType);
        $this->assertSame($mimeType, $serializer->getMimeType());
    }

    protected function createSerializerMock()
    {
        $serializer = $this->getMockForAbstractClass('InoPerunApi\Client\Serializer\AbstractSerializer');
        return $serializer;
    }
}