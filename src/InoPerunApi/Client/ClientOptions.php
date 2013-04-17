<?php

namespace InoPerunApi\Client;

use Zend\Stdlib\AbstractOptions;


class ClientOptions extends AbstractOptions
{

    protected $url = null;


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