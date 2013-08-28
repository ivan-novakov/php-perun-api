<?php

namespace InoPerunApiTest\Entity\Collection;

use InoPerunApi\Entity\Collection\UserExtSourceCollection;


class UserExtSourceCollectionTest extends \PHPUnit_Framework_TestCase
{


    public function testIsAllowedWithInvalidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\GenericEntity');
        
        $collection = new UserExtSourceCollection();
        $this->assertFalse($collection->isAllowed($entity));
    }


    public function testIsAllowedWithValidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\UserExtSource');
        
        $collection = new UserExtSourceCollection();
        $this->assertTrue($collection->isAllowed($entity));
    }
}