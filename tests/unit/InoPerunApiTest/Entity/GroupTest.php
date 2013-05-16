<?php

namespace InoPerunApiTest\Entity;

use InoPerunApi\Entity\Group;


class GroupTest extends \PHPUnit_Framework_TestCase
{


    public function testGetEntityBeanName()
    {
        $group = new Group();
        $this->assertSame('Group', $group->getEntityBeanName());
    }
}