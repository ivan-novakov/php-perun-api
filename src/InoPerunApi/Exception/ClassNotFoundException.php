<?php

namespace InoPerunApi\Exception;


class ClassNotFoundException extends \RuntimeException
{


    public function __construct($className)
    {
        parent::__construct(sprintf("Class '%s' not found", $className));
    }
}