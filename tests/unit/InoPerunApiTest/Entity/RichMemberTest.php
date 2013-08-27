<?php

namespace InoPerunApiTest\Entity;

use InoPerunApi\Entity\RichMember;


class RichMemberTest extends \PHPUnit_Framework_TestCase
{


    public function testGetEntityBeanName()
    {
        $richMember = new RichMember();
        $this->assertSame('RichMember', $richMember->getEntityBeanName());
    }
}