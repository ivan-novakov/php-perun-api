<?php

namespace InoPerunApi\Manager;

use InoPerunApi\Client\Client;
use InoPerunApi\Entity;


class GenericManager
{

    /**
     * The manager name.
     * @var string
     */
    protected $managerName = null;

    /**
     * Perun client.
     * @var Client
     */
    protected $client = null;

    /**
     * Entity factory.
     * @var Entity\Factory\FactoryInterface
     */
    protected $entityFactory = null;


    /**
     * Constructor.
     * 
     * @param Client $client
     * @param Entity\Factory\FactoryInterface $entityFactory
     */
    public function __construct(Client $client, Entity\Factory\FactoryInterface $entityFactory = null)
    {
        $this->setClient($client);
        
        if (null !== $entityFactory) {
            $this->setEntityFactory($entityFactory);
        }
    }


    /**
     * Sets the manager name.
     * 
     * @param string $managerName
     */
    public function setManagerName($managerName)
    {
        $this->managerName = $managerName;
    }


    /**
     * Returns the manager name.
     * 
     * @return string
     */
    public function getManagerName()
    {
        return $this->managerName;
    }


    /**
     * Sets the Perun client.
     * 
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }


    /**
     * Returns the Perun client.
     * 
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }


    /**
     * Sets the entity factory.
     * 
     * @param Entity\Factory\FactoryInterface $entityFactory
     */
    public function setEntityFactory(Entity\Factory\FactoryInterface $entityFactory)
    {
        $this->entityFactory = $entityFactory;
    }


    /**
     * Returns the entity factory.
     * 
     * @return Entity\Factory\FactoryInterface
     */
    public function getEntityFactory()
    {
        if (! $this->entityFactory instanceof Entity\Factory\FactoryInterface) {
            $this->entityFactory = new Entity\Factory\GenericFactory();
        }
        return $this->entityFactory;
    }
    
    
    public function callMethod($methodName, array $params = array(), $changeState = false)
    {
        
    }
}