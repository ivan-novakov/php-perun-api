<?php

namespace InoPerunApi\Client;


class Error
{

    protected $id = null;

    protected $type = null;

    protected $message = null;


    public function __construct($id, $type, $message)
    {
        $this->id = $id;
        $this->type = $type;
        $this->message = $message;
    }


    public function getId()
    {
        return $this->id;
    }


    public function getType()
    {
        return $this->type;
    }


    public function getMessage()
    {
        return $this->message;
    }
}