<?php

namespace InoPerunApiTest\Entity;

use InoPerunApi\Entity\Member;


class MemberTest extends \PHPUnit_Framework_TestCase
{


    public function testGetEntityBeanName()
    {
        $member = new Member();
        $this->assertSame('Member', $member->getEntityBeanName());
    }
}