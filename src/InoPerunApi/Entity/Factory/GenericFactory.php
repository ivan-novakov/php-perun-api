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
        
        throw new Exception\InvalidEntityDataException(
            sprintf("Passed data are neither entity data, nor entity collection data."));
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
        
        return new GenericEntity($data);
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
        return (is_array($data[0]) && isset($data[0][$this->getBeanPropertyName()]));
    }
}