<?php


class __TestClass
{

    protected $options = null;


    public function __construct($options = array())
    {
        $this->options = $options;
    }


    public function getOptions()
    {
        return $this->options;
    }
}