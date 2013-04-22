<?php

namespace InoPerunApi\Entity;

use Zend\Stdlib\ArrayObject;


abstract class AbstractEntity implements EntityInterface
{

    /**
     * The entity properties.
     * @var ArrayObject
     */
    protected $properties = null;


    /**
     * Constructor.
     * 
     * @param array $properties
     */
    public function __construct(array $properties = array())
    {
        $this->setProperties($properties);
    }


    /**
     * Sets the entity properties.
     * 
     * @param array $properties
     */
    public function setProperties(array $properties)
    {
        $this->properties = new ArrayObject($properties);
    }


    /**
     * Returns the entity properties.
     * 
     * @return array
     */
    public function getProperties()
    {
        return $this->properties->getArrayCopy();
    }


    /**
     * Sets the value of a single property.
     * 
     * @param string $name
     * @param mixed $value
     */
    public function setProperty($name, $value)
    {
        $this->properties->offsetSet($name, $value);
    }


    /**
     * Returns the value of a property.
     * 
     * @param string $name
     * @return mixed|null
     */
    public function getProperty($name)
    {
        if ($this->properties->offsetExists($name)) {
            return $this->properties->offsetGet($name);
        }
        
        return null;
    }


    public function __call($methodName, array $arguments)
    {
        if (preg_match('/^get(\w+)$/', $methodName, $matches)) {
            $propertyName = lcfirst($matches[1]);
            return $this->getProperty($propertyName);
        }
        
        if (preg_match('/set(\w+)$/', $methodName, $matches)) {
            $propertyName = lcfirst($matches[1]);
            return call_user_func_array(array(
                $this, 
                'setProperty'
            ), array(
                $propertyName, 
                $arguments[0]
            ));
        }
        
        throw new Exception\InvalidMethodException(sprintf("Invalid method %s::%s()", get_class($this), $methodName));
    }
}