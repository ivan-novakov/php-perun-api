<?php

namespace InoPerunApiTest\Entity;

use InoPerunApi\Entity\RichUser;


class RichUserTest extends \PHPUnit_Framework_TestCase
{


    public function testGetEntityBeanName()
    {
        $richUser = new RichUser();
        $this->assertSame('RichUser', $richUser->getEntityBeanName());
    }
}