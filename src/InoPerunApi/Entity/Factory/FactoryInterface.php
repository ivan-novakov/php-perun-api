<?php

namespace InoPerunApi\Entity\Factory;


interface FactoryInterface
{


    /**
     * Creates either entity or a collection of entities, depending on the provided data.
     * 
     * @param array $data
     */
    public function create(array $data);


    /**
     * Creates an entity based on the provided data.
     * 
     * @param array $data
     */
    public function createEntity(array $data);


    /**
     * Creates an entity collection based on the provided data.
     * 
     * @param array $data
     */
    public function createEntityCollection(array $data);
}