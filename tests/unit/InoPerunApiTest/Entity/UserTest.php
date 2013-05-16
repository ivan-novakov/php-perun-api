<?php

namespace InoPerunApiTest\Entity;

use InoPerunApi\Entity\User;


class UserTest extends \PHPUnit_Framework_TestCase
{


    public function testGetEntityBeanName()
    {
        $user = new User();
        $this->assertSame('User', $user->getEntityBeanName());
    }
}
