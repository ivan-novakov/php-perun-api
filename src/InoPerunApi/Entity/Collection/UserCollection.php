<?php

namespace InoPerunApi\Entity\Collection;


use InoPerunApi\Entity\EntityInterface;
use InoPerunApi\Entity\User;
class UserCollection extends Collection
{
    
    public function isAllowed(EntityInterface $entity)
    {
        return ($entity instanceof User);
    }
}