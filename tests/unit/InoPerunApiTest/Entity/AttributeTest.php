<?php

namespace InoPerunApiTest\Entity;

use InoPerunApi\Entity\Attribute;


class AttributeTest extends \PHPUnit_Framework_TestCase
{


    public function testGetEntityBeanName()
    {
        $attribute = new Attribute();
        $this->assertSame('Attribute', $attribute->getEntityBeanName());
    }
}