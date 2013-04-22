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


    /**
     * Sets the value of a single property.
     *
     * @param string $name
     * @param mixed $value
     */
    public function setProperty($name, $value);


    /**
     * Returns the value of a property.
     *
     * @param string $name
     * @return mixed|null
     */
    public function getProperty($name);
}