<?php

namespace InoPerunApiTest\Entity\Collection;

use InoPerunApi\Entity\Collection\AttributeCollection;


class AttributeCollectionTest extends \PHPUnit_Framework_TestCase
{


    public function testIsAllowedWithInvalidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\GenericEntity');
        
        $collection = new AttributeCollection();
        $this->assertFalse($collection->isAllowed($entity));
    }


    public function testIsAllowedWithValidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\Attribute');
        
        $collection = new AttributeCollection();
        $this->assertTrue($collection->isAllowed($entity));
    }
}