<?php

namespace InoPerunApi\Entity\Collection;

use Zend\Stdlib\ArrayObject;
use InoPerunApi\Entity\AbstractEntity;
use InoPerunApi\Entity\EntityInterface;


class Collection implements \Countable, \IteratorAggregate
{

    /**
     * The list of entities.
     * 
     * @var ArrayObject
     */
    protected $entities = null;


    /**
     * Constructor.
     * 
     * @param array $entities
     */
    public function __construct(array $entities = array())
    {
        $this->setEntities($entities);
    }


    /**
     * Sets all entites at once.
     * 
     * @param array $entities
     */
    public function setEntities(array $entities)
    {
        $this->entities = new ArrayObject($entities);
    }


    /**
     * Returns all entities.
     * 
     * @return array
     */
    public function getEntities()
    {
        return $this->entities->getArrayCopy();
    }


    /**
     * Returns the entity count.
     * 
     * @return integer
     */
    public function count()
    {
        return $this->entities->count();
    }


    /**
     * Returns the collection iterator.
     * 
     * @return \Iterator
     */
    public function getIterator()
    {
        return $this->entities->getIterator();
    }


    public function append(EntityInterface $entity)
    {
        $this->entities->append($entity);
    }
}