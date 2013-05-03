<?php

namespace InoPerunApiTest\Entity\Factory;

use InoPerunApi\Entity\Factory\GenericFactory;


class GenericFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
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


    public function testSetBeanToEntityClassMappings()
    {
        $mappings = array(
            'foo' => 'bar'
        );
        
        $this->factory->setBeanToEntityClassMappings($mappings);
        $this->assertSame($mappings, $this->factory->getBeanToEntityClassMappings());
    }


    public function testGetEntityClassForBean()
    {
        $mappings = array(
            'foo' => 'bar'
        );
        $this->factory->setBeanToEntityClassMappings($mappings);
        $this->assertSame('bar', $this->factory->getEntityClassForBean('foo'));
    }


    public function testCreateFromResponsePayload()
    {
        $params = array(
            'foo' => 'bar'
        );
        
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        $payload->expects($this->once())
            ->method('getParams')
            ->will($this->returnValue($params));
        
        $entity = $this->getMock('InoPerunApi\Entity\EntityInterface');
        
        $factory = $this->getMockBuilder('InoPerunApi\Entity\Factory\GenericFactory')
            ->setMethods(array(
            'create'
        ))
            ->getMock();
        $factory->expects($this->once())
            ->method('create')
            ->with($params)
            ->will($this->returnValue($entity));
        
        $entity = $factory->createFromResponsePayload($payload);
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


    public function testCreateWithRecursiveData()
    {
        $simpleArray = array(
            'some_key' => 'some_value'
        );
        $data = array(
            'id' => 123,
            'beanName' => 'foo',
            
            'simpleArray' => $simpleArray,
            
            'embeddedEntity' => array(
                'name' => 'embedded entity',
                'beanName' => 'embedded'
            ),
            
            'embeddedCollection' => array(
                array(
                    'id' => 12,
                    'beanName' => 'embeddedCol'
                ),
                array(
                    'id' => 13,
                    'beanName' => 'embeddedCol'
                )
            )
        );
        
        $entity = $this->factory->create($data);
        $this->assertInstanceOf('InoPerunApi\Entity\EntityInterface', $entity);
        $this->assertSame(123, $entity->getId());
        $this->assertSame('foo', $entity->getEntityName());
        $this->assertSame($simpleArray, $entity->getSimpleArray());
        
        $embeddedEntity = $entity->getEmbeddedEntity();
        $this->assertInstanceOf('InoPerunApi\Entity\EntityInterface', $embeddedEntity);
        $this->assertSame('embedded entity', $embeddedEntity->getName());
        $this->assertSame('embedded', $embeddedEntity->getEntityName());
        
        $embeddedCollection = $entity->getEmbeddedCollection();
        $this->assertInstanceOf('InoPerunApi\Entity\Collection\Collection', $embeddedCollection);
        $this->assertSame(12, $embeddedCollection->getAt(0)
            ->getId());
        $this->assertSame(13, $embeddedCollection->getAt(1)
            ->getId());
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


    public function testSimpleCreateEntityWithMissingBeanName()
    {
        $this->setExpectedException('InoPerunApi\Entity\Factory\Exception\InvalidEntityDataException');
        
        $data = array(
            'foo' => 'bar'
        );
        
        $this->factory->simpleCreateEntity($data);
    }


    public function testSimpleCreateEntityWithUndefinedClass()
    {
        $this->setExpectedException('InoPerunApi\Entity\Factory\Exception\EntityClassNotFoundException');
        
        $this->factory->setBeanToEntityClassMappings(array(
            'testBean' => 'UndefinedClass'
        ));
        
        $this->factory->simpleCreateEntity(array(
            'beanName' => 'testBean'
        ));
    }


    public function testSimpleCreateEntity()
    {
        include TESTS_ROOT_DIR . '/data/__TestEntityClass.php';
        
        $this->factory->setBeanToEntityClassMappings(array(
            'testBean' => '__TestEntityClass'
        ));
        
        $entity = $this->factory->simpleCreateEntity(array(
            'beanName' => 'testBean'
        ));
        
        $this->assertInstanceOf('__TestEntityClass', $entity);
    }
}