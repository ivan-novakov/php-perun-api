<?php

namespace InoPerunApi\Entity;


interface EntityInterface
{


    /**
     * Sets the entity properties.
     *
     * @param array $properties
     */
    public function setProperties(array $properties);


    /**
     * Returns the entity properties.
     *
     * @return array
     */
    public function getProperties();
}