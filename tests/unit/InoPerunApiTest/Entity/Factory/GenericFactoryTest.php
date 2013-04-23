<?php

namespace InoPerunApiTest\Entity\Factory;

use InoPerunApi\Entity\Factory\GenericFactory;


class GenericFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var GenericFactory
     */
    protected $factory = null;


    public function setUp()
    {
        $this->factory = new GenericFactory();
    }


    public function testSetBeanPropertyName()
    {
        $beanPropertyName = 'beanName';
        $this->factory->setBeanPropertyName($beanPropertyName);
        $this->assertSame($beanPropertyName, $this->factory->getBeanPropertyName());
    }


    public function testCreateWithEmptyArray()
    {
        $this->assertNull($this->factory->create(array()));
    }


    public function testCreateWithEntityData()
    {
        $beanPropertyName = 'beanName';
        $data = array(
            $beanPropertyName => 'foo'
        );
        $entity = $this->getMock('InoPerunApi\Entity\EntityInterface');
        
        $factory = $this->getMockBuilder('InoPerunApi\Entity\Factory\GenericFactory')
            ->setMethods(array(
            'createEntity'
        ))
            ->getMock();
        $factory->expects($this->once())
            ->method('createEntity')
            ->with($data)
            ->will($this->returnValue($entity));
        
        $factory->setBeanPropertyName($beanPropertyName);
        $expectedEntity = $factory->create($data);
        $this->assertSame($expectedEntity, $entity);
    }


    public function testCreateWithCollectionData()
    {
        $beanPropertyName = 'beanName';
        $data = array(
            array(
                $beanPropertyName => 'foo'
            )
        );
        $collection = $this->getMock('InoPerunApi\Entity\Collection\Collection');
        
        $factory = $this->getMockBuilder('InoPerunApi\Entity\Factory\GenericFactory')
            ->setMethods(array(
            'createEntityCollection'
        ))
            ->getMock();
        
        $factory->expects($this->once())
            ->method('createEntityCollection')
            ->with($data)
            ->will($this->returnValue($collection));
        
        $expectedCollection = $factory->create($data);
        $this->assertSame($expectedCollection, $collection);
    }


    public function testCreateWithInvalidData()
    {
        $this->setExpectedException('InoPerunApi\Entity\Factory\Exception\InvalidEntityDataException');
        $data = array(
            'cinvalid data'
        );
        $this->factory->create($data);
    }


    public function testCreateEntityWithInvalidData()
    {
        $this->setExpectedException('InoPerunApi\Entity\Factory\Exception\InvalidEntityDataException');
        
        $this->factory->createEntity(array(
            'invalid data'
        ));
    }


    public function testCreateEntity()
    {
        $data = array(
            'id' => 123, 
            'beanName' => 'foo'
        );
        $entity = $this->factory->createEntity($data);
        $this->assertInstanceOf('InoPerunApi\Entity\EntityInterface', $entity);
        $this->assertSame(123, $entity->getProperty('id'));
    }


    public function testCreateEntityCollection()
    {
        $data = array(
            array(
                'id' => 123, 
                'beanName' => 'foo'
            ), 
            array(
                'id' => 456, 
                'beanName' => 'foo'
            )
        );
        $entities = array(
            $this->getMock('InoPerunApi\Entity\EntityInterface'), 
            $this->getMock('InoPerunApi\Entity\EntityInterface')
        );
        
        $factory = $this->getMockBuilder('InoPerunApi\Entity\Factory\GenericFactory')
            ->setMethods(array(
            'createEntity'
        ))
            ->getMock();
        
        for ($i = 0; $i < count($data); $i ++) {
            $factory->expects($this->at($i))
                ->method('createEntity')
                ->with($data[$i])
                ->will($this->returnValue($entities[$i]));
        }
        
        $collection = $factory->createEntityCollection($data);
        $this->assertInstanceOf('InoPerunApi\Entity\Collection\Collection', $collection);
        
        $this->assertSame($entities, $collection->getEntities());
    }
}