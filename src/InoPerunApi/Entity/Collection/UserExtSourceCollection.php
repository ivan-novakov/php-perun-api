<?php

namespace InoPerunApi\Entity\Collection;

use InoPerunApi\Entity\EntityInterface;
use InoPerunApi\Entity\UserExtSource;


class UserExtSourceCollection extends Collection
{


    public function isAllowed(EntityInterface $entity)
    {
        return ($entity instanceof UserExtSource);
    }
}