<?php

namespace InoPerunApi\Entity\Collection;

use InoPerunApi\Entity\EntityInterface;
use InoPerunApi\Entity\Group;


class GroupCollection extends Collection
{


    public function isAllowed(EntityInterface $entity)
    {
        return ($entity instanceof Group);
    }
}