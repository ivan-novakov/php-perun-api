<?php

namespace InoPerunApiTest\Entity\Collection;

use InoPerunApi\Entity\Collection\Collection;


class CollectionTest extends \PHPUnit_Framework_TestCase
{


    public function testSetEntities()
    {
        $entities = $this->createEntityArray();
        
        $collection = $this->getMockBuilder('InoPerunApi\Entity\Collection\Collection')
            ->setMethods(array(
            'isAllowed'
        ))
            ->getMock();
        
        foreach ($entities as $index => $entity) {
            $collection->expects($this->at($index))
                ->method('isAllowed')
                ->with($entity)
                ->will($this->returnValue(true));
        }
        
        $collection->setEntities($entities);
        $this->assertSame($entities, $collection->getEntities());
    }


    public function testSetEntitiesWithInvalidEntity()
    {
        $this->setExpectedException('InoPerunApi\Entity\Collection\Exception\InvalidEntityException');
        
        $entities = $this->createEntityArray();
        $allowed = array(
            true,
            false
        );
        
        $collection = $this->getMockBuilder('InoPerunApi\Entity\Collection\Collection')
            ->setMethods(array(
            'isAllowed'
        ))
            ->getMock();
        
        foreach ($entities as $index => $entity) {
            $collection->expects($this->at($index))
                ->method('isAllowed')
                ->with($entity)
                ->will($this->returnValue($allowed[$index]));
        }
        
        $collection->setEntities($entities);
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
        
        $collection = $this->getMockBuilder('InoPerunApi\Entity\Collection\Collection')
            ->setMethods(array(
            'isAllowed'
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


    public function testAppendCollection()
    {
        $entity1 = $this->createEntityMock();
        $entity2 = $this->createEntityMock();
        $entity3 = $this->createEntityMock();
        $entity4 = $this->createEntityMock();
        $entity5 = $this->createEntityMock();
        
        $col1 = new Collection(array(
            $entity1,
            $entity2,
            $entity3
        ));
        
        $col2 = new Collection(array(
            $entity4,
            $entity5
        ));
        
        $col1->appendCollection($col2);
        
        $this->assertCount(5, $col1);
        $this->assertSame($entity4, $col1->getAt(3));
        $this->assertSame($entity5, $col1->getAt(4));
    }
    
    /*
     * 
     */
    protected function createEntityArray()
    {
        return array(
            $this->createEntityMock(),
            $this->createEntityMock()
        );
    }


    protected function createEntityMock()
    {
        return $this->getMock('InoPerunApi\Entity\EntityInterface');
    }
}