<?php

namespace InoPerunApi\Util;

use InoPerunApi\Exception as CommonException;


class GenericFactory
{

    const OPT_CLASS = 'class';

    const OPT_OPTIONS = 'options';


    public function factory(array $config = array())
    {
        if (! isset($config[self::OPT_CLASS])) {
            throw new CommonException\MissingOptionException(self::OPT_CLASS);
        }
        
        $className = $config[self::OPT_CLASS];
        if (! class_exists($className)) {
            throw new CommonException\ClassNotFoundException($className);
        }
        
        $options = array();
        if (isset($config[self::OPT_OPTIONS]) && is_array($config[self::OPT_OPTIONS])) {
            $options = $config[self::OPT_OPTIONS];
        }
        
        return new $className($options);
    }
}