<?php

namespace InoPerunApiTest\Entity\Collection;

use InoPerunApi\Entity\Collection\RichUserCollection;
use InoPerunApi\Entity\GenericEntity;


class RichUserCollectionTest extends \PHPUnit_Framework_TestCase
{


    public function testIsAllowedWithInvalidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\GenericEntity');
        
        $userCollection = new RichUserCollection();
        $this->assertFalse($userCollection->isAllowed($entity));
    }


    public function testIsAllowedWithValidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\RichUser');
        
        $userCollection = new RichUserCollection();
        $this->assertTrue($userCollection->isAllowed($entity));
    }
}