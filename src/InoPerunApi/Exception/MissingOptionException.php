<?php

namespace InoPerunApi\Exception;


class MissingOptionException extends \RuntimeException
{


    public function __construct($optionName)
    {
        parent::__construct(sprintf("Missing option '%s'", $optionName));
    }
}