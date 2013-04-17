<?php

namespace InoPerunApi\Client\Http;

use Zend\Http\Client;


class ClientFactory
{


    public function createClient(array $config = array())
    {
        $client = new Client(null, $config);     
        return $client;
    }
}