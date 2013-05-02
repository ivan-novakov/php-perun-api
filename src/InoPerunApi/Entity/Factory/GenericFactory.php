<?php

namespace InoPerunApi\Entity\Factory;

use InoPerunApi\Entity\GenericEntity;
use InoPerunApi\Entity\Collection\Collection;


class GenericFactory implements FactoryInterface
{

    /**
     * The "bean name" property name.
     * 
     * @var string
     */
    protected $beanPropertyName = null;

    protected $defaultEntityClass = 'InoPerunApi\Entity\GenericEntity';

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
    protected function simpleCreateEntity(array $data)
    {
        return new GenericEntity($data);
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