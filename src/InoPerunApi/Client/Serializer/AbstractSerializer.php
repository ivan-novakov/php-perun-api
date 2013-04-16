<?php

namespace InoPerunApi\Client\Serializer;


abstract class AbstractSerializer implements SerializerInterface
{

    /**
     * The serializer "code".
     * @var string
     */
    protected $code = 'generic';


    public function setCode($code)
    {
        $this->code = $code;
    }


    public function getCode()
    {
        return $this->code;
    }
}