<?php

namespace InoPerunApi\Entity\Collection;

use InoPerunApi\Entity\EntityInterface;
use InoPerunApi\Entity\Attribute;


class AttributeCollection extends Collection
{


    public function isAllowed(EntityInterface $entity)
    {
        return ($entity instanceof Attribute);
    }
}