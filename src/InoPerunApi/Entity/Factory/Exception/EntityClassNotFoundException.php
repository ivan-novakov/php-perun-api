<?php

namespace InoPerunApi\Entity\Factory\Exception;


class EntityClassNotFoundException extends \RuntimeException
{


    public function __construct($entityClassName)
    {
        parent::__construct(sprintf("Undefined entity class '%s'", $entityClassName));
    }
}