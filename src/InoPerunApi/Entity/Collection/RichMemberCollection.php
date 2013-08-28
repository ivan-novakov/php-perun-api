<?php

namespace InoPerunApi\Entity\Collection;

use InoPerunApi\Entity\EntityInterface;
use InoPerunApi\Entity\RichMember;


class RichMemberCollection extends Collection
{


    public function isAllowed(EntityInterface $entity)
    {
        return ($entity instanceof RichMember);
    }
}