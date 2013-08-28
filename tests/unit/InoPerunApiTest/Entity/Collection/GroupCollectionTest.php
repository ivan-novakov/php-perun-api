<?php

namespace InoPerunApiTest\Entity\Collection;

use InoPerunApi\Entity\Collection\GroupCollection;


class GroupCollectionTest extends \PHPUnit_Framework_TestCase
{


    public function testIsAllowedWithInvalidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\GenericEntity');
        
        $collection = new GroupCollection();
        $this->assertFalse($collection->isAllowed($entity));
    }


    public function testIsAllowedWithValidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\Group');
        
        $collection = new GroupCollection();
        $this->assertTrue($collection->isAllowed($entity));
    }
}