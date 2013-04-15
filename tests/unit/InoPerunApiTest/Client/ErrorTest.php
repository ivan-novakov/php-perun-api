<?php

namespace InoPerunApiTest\Client;

use InoPerunApi\Client\Error;


class ErrorTest extends \PHPUnit_Framework_TestCase
{


    public function testConstructor()
    {
        $id = '100';
        $type = 'some_type';
        $message = 'Some message';
        
        $error = new Error($id, $type, $message);
        $this->assertSame($id, $error->getId());
        $this->assertSame($type, $error->getType());
        $this->assertSame($message, $error->getMessage());
    }
}