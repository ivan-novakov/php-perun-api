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


    public function getEntityName()
    {
        return $this->getProperty(self::PROP_BEAN_NAME);
    }
}