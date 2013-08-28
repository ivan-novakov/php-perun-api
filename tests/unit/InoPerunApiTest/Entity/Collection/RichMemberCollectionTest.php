<?php

namespace InoPerunApiTest\Entity\Collection;

use InoPerunApi\Entity\Collection\RichMemberCollection;


class RichMemberCollectionTest extends \PHPUnit_Framework_TestCase
{


    public function testIsAllowedWithInvalidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\GenericEntity');
        
        $collection = new RichMemberCollection();
        $this->assertFalse($collection->isAllowed($entity));
    }


    public function testIsAllowedWithValidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\RichMember');
        
        $collection = new RichMemberCollection();
        $this->assertTrue($collection->isAllowed($entity));
    }
}