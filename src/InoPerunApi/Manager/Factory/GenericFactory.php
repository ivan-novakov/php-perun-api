<?php

namespace InoPerunApi\Manager\Factory;

use InoPerunApi\Client\Client;
use InoPerunApi\Manager\GenericManager;


class GenericFactory implements FactoryInterface
{

    /**
     * A list of supported managers.
     * @var array
     */
    protected $supportedManagers = array(
        'usersManager',
        'groupsManager',
        'membersManager'
    );


    /**
     * Sets the supported managers.
     * 
     * @param array $supportedManagers
     */
    public function setSupportedManagers(array $supportedManagers)
    {
        $this->supportedManagers = $supportedManagers;
    }


    /**
     * Returns the supported managers.
     * 
     * @return array
     */
    public function getSupportedManagers()
    {
        return $this->supportedManagers;
    }


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Manager\Factory\FactoryInterface::createManager()
     */
    public function createManager($managerName, Client $client)
    {
        if (! $this->isSupported($managerName)) {
            throw new Exception\UnsupportedManagerException(sprintf("Unsupported manager '%s'", $managerName));
        }
        
        $manager = new GenericManager($client);
        $manager->setManagerName($managerName);
        
        return $manager;
    }


    /**
     * Returns true, if the manager is supported.
     * 
     * @param string $managerName
     * @return boolean
     */
    public function isSupported($managerName)
    {
        return (in_array($managerName, $this->supportedManagers));
    }
}