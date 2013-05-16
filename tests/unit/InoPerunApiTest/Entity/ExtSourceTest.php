<?php

namespace InoPerunApiTest\Entity;

use InoPerunApi\Entity\ExtSource;


class ExtSourceTest extends \PHPUnit_Framework_TestCase
{


    public function testGetEntityBeanName()
    {
        $extSource = new ExtSource();
        $this->assertSame('ExtSource', $extSource->getEntityBeanName());
    }
}