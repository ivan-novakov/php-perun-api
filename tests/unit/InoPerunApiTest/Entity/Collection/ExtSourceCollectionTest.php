<?php

namespace InoPerunApiTest\Entity\Collection;

use InoPerunApi\Entity\Collection\ExtSourceCollection;


class ExtSourceCollectionTest extends \PHPUnit_Framework_TestCase
{


    public function testIsAllowedWithInvalidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\GenericEntity');
        
        $collection = new ExtSourceCollection();
        $this->assertFalse($collection->isAllowed($entity));
    }


    public function testIsAllowedWithValidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\ExtSource');
        
        $collection = new ExtSourceCollection();
        $this->assertTrue($collection->isAllowed($entity));
    }
}