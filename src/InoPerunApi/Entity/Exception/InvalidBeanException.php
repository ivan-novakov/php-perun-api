<?php

namespace InoPerunApi\Entity\Exception;

use InoPerunApi\Entity\EntityInterface;


class InvalidBeanException extends \InvalidArgumentException
{


    public function __construct($beanName, $expectedBeanName, EntityInterface $entity)
    {
        parent::__construct(sprintf("Invalid bean name '%s' for entity '%s', expected '%s'", $beanName, get_class($entity), $expectedBeanName));
    }
}