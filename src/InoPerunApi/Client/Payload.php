<?php

namespace InoPerunApi\Client;


class Payload
{

    protected $params = array();


    public function __construct(array $params = null)
    {
        if (null !== $params) {
            $this->setParams($params);
        }
    }


    public function setParams(array $params)
    {
        $this->params = $params;
    }


    public function getParams()
    {
        return $this->params;
    }


    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }


    public function getParam($name)
    {
        if (isset($this->param[$name])) {
            return $this->param[$name];
        }
        
        return null;
    }
}