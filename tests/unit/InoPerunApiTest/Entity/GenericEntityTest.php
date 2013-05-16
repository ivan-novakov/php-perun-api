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


    public function testSetEntityBeanName()
    {
        $entityBeanName = 'testBean';
        
        $this->entity->setEntityBeanName($entityBeanName);
        $this->assertSame($entityBeanName, $this->entity->getEntityBeanName());
    }


    public function testSetInvalidBeanName()
    {
        $this->setExpectedException('InoPerunApi\Entity\Exception\InvalidBeanException');
        
        $this->entity->setEntityBeanName('testBean');
        $this->entity->setBeanName('anotherBean');
    }


    public function testGetEntityName()
    {
        $beanName = 'testBeanName';
        $this->entity->setEntityBeanName($beanName);
        $this->entity->setProperties(array(
            'beanName' => $beanName
        ));
        
        $this->assertSame($beanName, $this->entity->getEntityName());
    }
}

