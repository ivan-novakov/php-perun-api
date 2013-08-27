<?php

namespace InoPerunApi\Manager\Factory;

use InoPerunApi\Client\Client;


/**
 * Manager factory interface.
 */
interface FactoryInterface
{


    /**
     * Creates a generic manager.
     * 
     * @param string $managerName
     * @param Client $client
     * @return GenericManager
     */
    public function createManager($managerName, Client $client);
}