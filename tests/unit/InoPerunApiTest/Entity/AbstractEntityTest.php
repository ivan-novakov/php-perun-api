<?php

namespace InoPerunApiTest\Entity;


class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{

    protected $entity = null;


    public function setUp()
    {
        $this->entity = $this->getMockForAbstractClass('InoPerunApi\Entity\AbstractEntity');
    }


    public function testMagicGetter()
    {
        $value = 'test value';
        $this->assertNull($this->entity->getFooBar());
        $this->entity->setProperties(array(
            'fooBar' => $value
        ));
        $this->assertSame($value, $this->entity->getFooBar());
    }


    public function testMagicSetter()
    {
        $value = 'test value';
        $this->assertNull($this->entity->getProperty('fooBar'));
        $this->entity->setFooBar($value);
        
        $properties = $this->entity->getProperties();
        $this->assertArrayHasKey('fooBar', $properties);
        $this->assertSame($value, $properties['fooBar']);
    }


    public function testInvalidMagicCall()
    {
        $this->setExpectedException('InoPerunApi\Entity\Exception\InvalidMethodException');
        
        $this->entity->someInvalidCall();
    }


    public function testSetProperties()
    {
        $properties = array(
            'foo' => 'bar'
        );
        $this->entity->setProperties($properties);
        $this->assertSame($properties, $this->entity->getProperties());
    }
}