<?php

namespace InoPerunApiTest\Entity\Collection;

use InoPerunApi\Entity\Collection\MemberCollection;


class MemberCollectionTest extends \PHPUnit_Framework_TestCase
{


    public function testIsAllowedWithInvalidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\GenericEntity');
        
        $collection = new MemberCollection();
        $this->assertFalse($collection->isAllowed($entity));
    }


    public function testIsAllowedWithValidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\Member');

        $collection = new MemberCollection();
        $this->assertTrue($collection->isAllowed($entity));
    }
}