<?php

namespace InoPerunApiTest\Entity\Collection;

use InoPerunApi\Entity\Collection\Collection;


class CollectionTest extends \PHPUnit_Framework_TestCase
{


    public function testSetEntities()
    {
        $entities = $this->createEntityArray();
        $collection = new Collection();
        $collection->setEntities($entities);
        $this->assertSame($entities, $collection->getEntities());
    }


    public function testCount()
    {
        $entities = $this->createEntityArray();
        $count = count($entities);
        $collection = new Collection($entities);
        $this->assertSame($count, $collection->count());
    }


    public function testGetIterator()
    {
        $collection = new Collection();
        $this->assertInstanceOf('Iterator', $collection->getIterator());
    }


    public function testGetAt()
    {
        $entity1 = $this->getMock('InoPerunApi\Entity\EntityInterface');
        $entity2 = $this->getMock('InoPerunApi\Entity\EntityInterface');
        
        $collection = new Collection(array(
            $entity1,
            $entity2
        ));
        
        $this->assertSame($entity1, $collection->getAt(0));
        $this->assertSame($entity2, $collection->getAt(1));
        $this->assertNull($collection->getAt(2));
    }


    public function testAppendWithInvalidEntity()
    {
        $this->setExpectedException('InoPerunApi\Entity\Collection\Exception\InvalidEntityException');
        
        $entities = $this->createEntityArray();
        $collection = $this->getMockBuilder('InoPerunApi\Entity\Collection\Collection')
            ->setMethods(array(
            'isAllowed'
        ))
            ->setConstructorArgs(array(
            $entities
        ))
            ->getMock();
        $collection->expects($this->once())
            ->method('isAllowed')
            ->will($this->returnValue(false));
        
        $newEntity = $this->getMock('InoPerunApi\Entity\EntityInterface');
        $collection->append($newEntity);
    }


    public function testAppend()
    {
        $entities = $this->createEntityArray();
        $collection = new Collection($entities);
        
        $newEntity = $this->getMock('InoPerunApi\Entity\EntityInterface');
        $collection->append($newEntity);
        
        $exportedEntities = $collection->getEntities();
        $this->assertSame($newEntity, $exportedEntities[count($entities)]);
    }


    protected function createEntityArray()
    {
        return array(
            $this->getMock('InoPerunApi\Entity\EntityInterface'),
            $this->getMock('InoPerunApi\Entity\EntityInterface')
        );
    }
}