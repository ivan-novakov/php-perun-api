<?php

namespace InoPerunApi\Entity;


class GenericEntity extends AbstractEntity
{

    const PROP_BEAN_NAME = 'beanName';


    public function getEntityName()
    {
        return $this->getProperty(self::PROP_BEAN_NAME);
    }
}