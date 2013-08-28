<?php

namespace InoPerunApi\Manager\Factory;

use InoPerunApi\Client\Client;
use InoPerunApi\Manager\GenericManager;
use InoPerunApi\Exception\MissingDependencyException;


class GenericFactory implements FactoryInterface
{

    /**
     * @var Client
     */
    protected $client;

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
     * Constructor.
     * 
     * @param Client $client
     */
    public function __construct(Client $client = null)
    {
        if (null !== $client) {
            $this->setClient($client);
        }
    }


    /**
     * @return Client
     */
    public function getClient()
    {
        if (! $this->client instanceof Client) {
            throw new MissingDependencyException('client', $this);
        }
        return $this->client;
    }


    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }


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
    public function createManager($managerName, Client $client = null)
    {
        if (null === $client) {
            $client = $this->getClient();
        }
        
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