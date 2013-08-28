<?php

namespace InoPerunApi\Entity\Collection;

use InoPerunApi\Entity\EntityInterface;
use InoPerunApi\Entity\ExtSource;


class ExtSourceCollection extends Collection
{


    public function isAllowed(EntityInterface $entity)
    {
        return ($entity instanceof ExtSource);
    }
}