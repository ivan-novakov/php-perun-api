<?php

namespace InoPerunApi\Exception;


class MissingDependencyException extends \RuntimeException
{


    public function __construct($dependency, $target)
    {
        parent::__construct(sprintf("Missing dependency '%s' for object '%s'", $dependency, is_object($target) ? get_class($target) : $target));
    }
}