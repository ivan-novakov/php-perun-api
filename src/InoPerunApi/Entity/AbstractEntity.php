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
        $this->properties = new ArrayObject();
        foreach ($properties as $name => $value) {
            $setterName = $this->createSetterName($name);
            call_user_func_array(array(
                $this,
                $setterName
            ), array(
                $value
            ));
        }
    }


    /**
     * Returns the entity properties.
     * 
     * @return array
     */
    public function getProperties()
    {
        $values = array();
        foreach ($this->properties as $name => $value) {
            $getterName = $this->createGetterName($name);
            $values[$name] = call_user_func_array(array(
                $this,
                $getterName
            ), array());
        }
        
        return $values;
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


    /**
     * Sets the value of a single property.
     *
     * @param string $name
     * @param mixed $value
     */
    protected function setProperty($name, $value)
    {
        $this->properties->offsetSet($name, $value);
    }


    /**
     * Returns the value of a property.
     *
     * @param string $name
     * @return mixed|null
     */
    protected function getProperty($name)
    {
        if ($this->properties->offsetExists($name)) {
            return $this->properties->offsetGet($name);
        }
        
        return null;
    }


    /**
     * Generates a setter name for the property.
     * 
     * @param string $propertyName
     * @return string
     */
    protected function createSetterName($propertyName)
    {
        return sprintf("set%s", ucfirst($propertyName));
    }


    /**
     * Generates a getter name for the property.
     * 
     * @param string $propertyName
     * @return string
     */
    protected function createGetterName($propertyName)
    {
        return sprintf("get%s", ucfirst($propertyName));
    }
}