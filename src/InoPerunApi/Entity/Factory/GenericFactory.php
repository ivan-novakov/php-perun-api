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
     * The default class for creating collections.
     * 
     * @var string
     */
    protected $defaultEntityCollectionClass = 'InoPerunApi\Entity\Collection\Collection';

    /**
     * Mapping between beans and PHP entity classes.
     * 
     * @var array
     */
    protected $beanToEntityClassMappings = array(
        'User' => 'InoPerunApi\Entity\User',
        'Group' => 'InoPerunApi\Entity\Group',
        'RichUser' => 'InoPerunApi\Entity\RichUser',
        'Attribute' => 'InoPerunApi\Entity\Attribute',
        'ExtSource' => 'InoPerunApi\Entity\ExtSource',
        'UserExtSource' => 'InoPerunApi\Entity\UserExtSource',
        'Member' => 'InoPerunApi\Entity\Member',
        'RichMember' => 'InoPerunApi\Entity\RichMember'
    );

    /**
     * Mapping between beans and PHP entity collection classes.
     * 
     * @var array
     */
    protected $beanToCollectionClassMappings = array(
        'User' => 'InoPerunApi\Entity\Collection\UserCollection',
        'Group' => 'InoPerunApi\Entity\Collection\GroupCollection',
        'RichUser' => 'InoPerunApi\Entity\Collection\RichUserCollection',
        'Attribute' => 'InoPerunApi\Entity\Collection\AttributeCollection',
        'ExtSource' => 'InoPerunApi\Entity\Collection\ExtSourceCollection',
        'UserExtSource' => 'InoPerunApi\Entity\Collection\UserExtSourceCollection',
        'Member' => 'InoPerunApi\Entity\Collection\MemberCollection',
        'RichMember' => 'InoPerunApi\Entity\Collection\RichMemberCollection'
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
     * @return array
     */
    public function getBeanToCollectionClassMappings()
    {
        return $this->beanToCollectionClassMappings;
    }


    /**
     * @param array $beanToCollectionClassMappings
     */
    public function setBeanToCollectionClassMappings(array $beanToCollectionClassMappings)
    {
        $this->beanToCollectionClassMappings = $beanToCollectionClassMappings;
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
        if (! $this->isCollectionData($data)) {
            throw new Exception\InvalidCollectionDataException('Passed data are not collection data');
        }
        
        $beanName = $this->getCollectionBeanName($data);
        $collectionClass = $this->getEntityCollectionClassForBean($beanName);
        
        $entities = array();
        foreach ($data as $entityData) {
            $entities[] = $this->createEntity($entityData);
        }
        
        return new $collectionClass($entities);
    }


    /**
     * Creates the entity object.
     * 
     * @param array $data
     * @return EntityInterface
     */
    public function simpleCreateEntity(array $data)
    {
        $beanName = $this->getEntityBeanName($data);
        if (null === $beanName) {
            throw new Exception\InvalidEntityDataException('Missing bean name in entity data');
        }
        
        return $this->createEntityWithName($beanName, $data);
    }


    /**
     * {@inhertidoc}
     * @see \InoPerunApi\Entity\Factory\FactoryInterface::createEntityWithName()
     */
    public function createEntityWithName($beanName, array $data = array())
    {
        $className = $this->getEntityClassForBean($beanName);
        if (! class_exists($className)) {
            throw new Exception\EntityClassNotFoundException($className);
        }
        
        return $this->createEntityWithClass($className, $data);
    }


    /**
     * Simply creates an entity with the provided class name and data.
     * 
     * @param string $className
     * @param array $data
     * @return EntityInterface
     */
    protected function createEntityWithClass($className, array $data = array())
    {
        return new $className($data);
    }


    /**
     * Extracts and returns the bean name from the data.
     * 
     * @param array $data
     * @return string|null
     */
    protected function getEntityBeanName(array $data)
    {
        if (isset($data[$this->getBeanPropertyName()])) {
            return $data[$this->getBeanPropertyName()];
        }
        
        return null;
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
     * Returns the entity collection class that corresponds to the bean.
     * If none is defined, the default collection class is returnes.
     *
     * @param string $beanName
     * @return string
     */
    public function getEntityCollectionClassForBean($beanName)
    {
        if (isset($this->beanToCollectionClassMappings[$beanName])) {
            return $this->beanToCollectionClassMappings[$beanName];
        }
        
        return $this->defaultEntityCollectionClass;
    }


    /**
     * Tries to extract the bean name of the records in a list (array).
     * 
     * @param array $data
     * @return string|null
     */
    protected function getCollectionBeanName(array $data)
    {
        if (isset($data[0]) && is_array($data[0])) {
            return $this->getEntityBeanName($data[0]);
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
     * Returns true, if the provided data are collection data.
     * 
     * @param array $data
     * @return boolean
     */
    protected function isCollectionData(array $data)
    {
        if (is_array($data)) {
            if (empty($data)) {
                return true;
            }
            
            if (isset($data[0][$this->getBeanPropertyName()])) {
                return true;
            }
        }
        
        return false;
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