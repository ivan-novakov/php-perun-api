<?php

namespace InoPerunApi\Entity\Collection;

use InoPerunApi\Entity\EntityInterface;
use InoPerunApi\Entity\RichUser;


class RichUserCollection extends Collection
{


    public function isAllowed(EntityInterface $entity)
    {
        return ($entity instanceof RichUser);
    }
}