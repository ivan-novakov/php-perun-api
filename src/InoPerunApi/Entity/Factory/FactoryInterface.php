<?php

namespace InoPerunApi\Entity\Factory;

use InoPerunApi\Client\Payload;


interface FactoryInterface
{


    /**
     * Creates and entity/collection from the provided payload object.
     * 
     * @param Payload $payload
     * @return Entity\EntityInterface|Entity\Collection\Collection
     */
    public function createFromResponsePayload(Payload $payload);


    /**
     * Creates either entity or a collection of entities, depending on the provided data.
     * 
     * @param array $data
     * @return Entity\EntityInterface|Entity\Collection\Collection
     */
    public function create(array $data);


    /**
     * Creates an entity based on the provided data.
     * 
     * @param array $data
     * @return Entity\EntityInterface|Entity\Collection\Collection
     */
    public function createEntity(array $data);


    /**
     * Creates an entity object corresponding to the provided bean name.
     * 
     * @param string $beanName
     * @param array $data
     * @return Entity\EntityInterface
     */
    public function createEntityWithName($beanName, array $data = array());
    
    /**
     * Creates an entity collection based on the provided data.
     * 
     * @param array $data
     * @return Entity\EntityInterface|Entity\Collection\Collection
     */
    public function createEntityCollection(array $data);
}