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