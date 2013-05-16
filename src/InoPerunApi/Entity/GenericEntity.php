<?php

namespace InoPerunApi\Entity;


/**
 * Generic entity.
 * 
 * @method integer getId()
 */
class GenericEntity extends AbstractEntity
{

    const PROP_ID = 'id';

    const PROP_BEAN_NAME = 'beanName';

    protected $entityBeanName = null;


    /**
     * Sets the bean name linked with this entity.
     * 
     * @param string $entityBeanName
     */
    public function setEntityBeanName($entityBeanName)
    {
        $this->entityBeanName = $entityBeanName;
    }


    /**
     * Returns the bean name linked with this entity.
     * 
     * @return string
     */
    public function getEntityBeanName()
    {
        return $this->entityBeanName;
    }


    /**
     * Sets the bean name.
     * 
     * @param string $beanName
     * @throws Exception\InvalidBeanException
     */
    public function setBeanName($beanName)
    {
        if (null !== $this->entityBeanName && $beanName != $this->entityBeanName) {
            throw new Exception\InvalidBeanException($beanName, $this->entityBeanName, $this);
        }
        
        parent::setBeanName($beanName);
    }


    /**
     * Returns the name of the entity.
     * 
     * @return string
     */
    public function getEntityName()
    {
        return $this->getBeanName();
    }
}