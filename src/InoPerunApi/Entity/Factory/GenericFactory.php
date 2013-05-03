<?php

namespace InoPerunApi\Entity\Factory;

use InoPerunApi\Entity\GenericEntity;
use InoPerunApi\Entity\Collection\Collection;
use InoPerunApi\Client\Payload;


class GenericFactory implements FactoryInterface
{

    /**
     * The "bean name" property name.
     * 
     * @var string
     */
    protected $beanPropertyName = null;

    /**
     * The default class used for creating entities.
     * 
     * @var string
     */
    protected $defaultEntityClass = 'InoPerunApi\Entity\GenericEntity';

    /**
     * Mapping between beans and PHP classes.
     * 
     * @var array
     */
    protected $beanToEntityClassMappings = array(
        'userBean' => 'InoPerunApi\Entity\User'
    );


    /**
     * Sets the bean name property name.
     * 
     * @param string $beanPropertyName
     */
    public function setBeanPropertyName($beanPropertyName)
    {
        $this->beanPropertyName = $beanPropertyName;
    }


    /**
     * Returns the bean name property name.
     * 
     * @return string
     */
    public function getBeanPropertyName()
    {
        if (null === $this->beanPropertyName) {
            $this->beanPropertyName = GenericEntity::PROP_BEAN_NAME;
        }
        
        return $this->beanPropertyName;
    }


    /**
     * Sets the bean to entity class mappings.
     * 
     * @param array $mappings
     */
    public function setBeanToEntityClassMappings(array $mappings)
    {
        $this->beanToEntityClassMappings = $mappings;
    }


    /**
     * Returns the bean to entity class mappings.
     * 
     * @return array
     */
    public function getBeanToEntityClassMappings()
    {
        return $this->beanToEntityClassMappings;
    }


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Entity\Factory\FactoryInterface::createFromResponsePayload()
     */
    public function createFromResponsePayload(Payload $payload)
    {
        return $this->create($payload->getParams());
    }


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Entity\Factory\FactoryInterface::create()
     */
    public function create(array $data)
    {
        if (empty($data)) {
            return null;
        }
        
        $beanPropertyName = $this->getBeanPropertyName();
        if ($this->isEntityData($data)) {
            return $this->createEntity($data);
        }
        
        if ($this->isEntityCollectionData($data)) {
            return $this->createEntityCollection($data);
        }
        
        throw new Exception\InvalidEntityDataException(sprintf("Passed data are neither entity data, nor entity collection data."));
    }


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Entity\Factory\FactoryInterface::createEntity()
     */
    public function createEntity(array $data)
    {
        if (! $this->isEntityData($data)) {
            throw new Exception\InvalidEntityDataException('Passed data are not entity data');
        }
        
        foreach ($data as $fieldName => $fieldValue) {
            if (is_array($fieldValue)) {
                if ($this->isEntityData($fieldValue)) {
                    $data[$fieldName] = $this->createEntity($fieldValue);
                }
                
                if ($this->isEntityCollectionData($fieldValue)) {
                    $data[$fieldName] = $this->createEntityCollection($fieldValue);
                }
            }
        }
        
        return $this->simpleCreateEntity($data);
    }


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Entity\Factory\FactoryInterface::createEntityCollection()
     */
    public function createEntityCollection(array $data)
    {
        $entities = array();
        foreach ($data as $entityData) {
            $entities[] = $this->createEntity($entityData);
        }
        
        return new Collection($entities);
    }


    /**
     * Returns the entity class that corresponds to the bean. If none is defined, the default class 
     * is returned.
     * 
     * @param string $beanName
     * @return string
     */
    public function getEntityClassForBean($beanName)
    {
        if (isset($this->beanToEntityClassMappings[$beanName])) {
            return $this->beanToEntityClassMappings[$beanName];
        }
        
        return $this->defaultEntityClass;
    }


    /**
     * Creates the entity object.
     * 
     * @param array $data
     * @return EntityInterface
     */
    public function simpleCreateEntity(array $data)
    {
        $beanName = $this->getBeanName($data);
        if (null === $beanName) {
            throw new Exception\InvalidEntityDataException('Missing bean name in entity data');
        }
        
        $className = $this->getEntityClassForBean($beanName);
        if (! class_exists($className)) {
            throw new Exception\EntityClassNotFoundException($className);
        }
        
        return new $className($data);
    }


    /**
     * Extracts and returns the bean name from the data.
     * 
     * @param array $data
     * @return string|null
     */
    protected function getBeanName(array $data)
    {
        if (isset($data[$this->getBeanPropertyName()])) {
            return $data[$this->getBeanPropertyName()];
        }
        
        return null;
    }


    /**
     * Returns true, if the provided data are an entity data.
     * 
     * @param array $data
     * @return boolean
     */
    protected function isEntityData(array $data)
    {
        return (isset($data[$this->getBeanPropertyName()]));
    }


    /**
     * Returns true if the provided data are an entity collection data.
     * 
     * @param array $data
     * @return boolean
     */
    protected function isEntityCollectionData(array $data)
    {
        return (isset($data[0]) && is_array($data[0]) && isset($data[0][$this->getBeanPropertyName()]));
    }
}