<?php

namespace InoPerunApi\Entity\Collection;

use InoPerunApi\Entity\EntityInterface;
use InoPerunApi\Entity\Member;


class MemberCollection extends Collection
{


    public function isAllowed(EntityInterface $entity)
    {
        return ($entity instanceof Member);
    }
}