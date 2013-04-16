<?php

namespace InoPerunApiTest\Client\Serializer;

use InoPerunApi\Client\Serializer\AbstractSerializer;


class AbstractSerializerTest extends \PHPUnit_Framework_TestCase
{


    public function testSetCode()
    {
        $serializer = $this->getMockForAbstractClass('InoPerunApi\Client\Serializer\AbstractSerializer');
        $code = 'test';
        $serializer->setCode($code);
        $this->assertSame($code, $serializer->getCode());
    }
}