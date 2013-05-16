<?php

namespace InoPerunApiTest\Entity;

use InoPerunApi\Entity\UserExtSource;


class UserExtSourceTest extends \PHPUnit_Framework_TestCase
{


    public function testGetEntityBeanName()
    {
        $userExtSource = new UserExtSource();
        $this->assertSame('UserExtSource', $userExtSource->getEntityBeanName());
    }
}