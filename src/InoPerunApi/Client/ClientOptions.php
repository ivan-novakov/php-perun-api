<?php

namespace InoPerunApi\Client;

use Zend\Stdlib\AbstractOptions;


class ClientOptions extends AbstractOptions
{

    protected $url = null;

    /**
     * The default 'changeState' value for all requests'.
     * @var boolean
     */
    protected $defaultChangeState = false;


    /**
     * @return boolean
     */
    public function getDefaultChangeState()
    {
        return $this->defaultChangeState;
    }


    /**
     * @param boolean $defaultChangeState
     */
    public function setDefaultChangeState($defaultChangeState)
    {
        $this->defaultChangeState = $defaultChangeState;
    }


    /**
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}