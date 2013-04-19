<?php

namespace InoPerunApiTest\Entity;

use InoPerunApi\Entity\GenericEntity;


class GenericEntityTest extends \PHPUnit_Framework_TestCase
{

    protected $entity = null;


    public function setUp()
    {
        $this->entity = new GenericEntity();
    }


    public function testEntityName()
    {
        $beanName = 'testBeanName';
        $this->entity->setProperty('beanName', $beanName);
        $this->assertSame($beanName, $this->entity->getEntityName());
    }
}

