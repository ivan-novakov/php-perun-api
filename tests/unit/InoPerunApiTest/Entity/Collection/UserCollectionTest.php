<?php

namespace InoPerunApiTest\Entity\Collection;

use InoPerunApi\Entity\Collection\UserCollection;
use InoPerunApi\Entity\GenericEntity;


class UserCollectionTest extends \PHPUnit_Framework_TestCase
{


    public function testIsAllowedWithInvalidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\GenericEntity');
        
        $userCollection = new UserCollection();
        $this->assertFalse($userCollection->isAllowed($entity));
    }


    public function testIsAllowedWithValidEntity()
    {
        $entity = $this->getMock('InoPerunApi\Entity\User');
        
        $userCollection = new UserCollection();
        $this->assertTrue($userCollection->isAllowed($entity));
    }
}