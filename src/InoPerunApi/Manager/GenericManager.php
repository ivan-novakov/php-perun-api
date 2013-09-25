<?php

namespace InoPerunApi\Manager;

use InoPerunApi\Client\Client;
use InoPerunApi\Entity;
use InoPerunApi\Entity\EntityInterface;
use InoPerunApi\Entity\Collection\Collection;
use InoPerunApi\Manager\Exception\PerunErrorException;


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


    /**
     * Performs a remote call to a manager method.
     * @param string $methodName
     * @param array $params
     * @param string $changeState
     * @throws Exception\ClientRuntimeException
     * @throws Exception\PerunErrorException
     * @return EntityInterface|Collection
     */
    public function callMethod($methodName, array $params = array(), $changeState = null)
    {
        $params = $this->paramsToArray($params);
        
        try {
            $response = $this->client->sendRequest($this->managerName, $methodName, $params, $changeState);
        } catch (\Exception $e) {
            throw new Exception\ClientRuntimeException(
                sprintf("Exception during client request: [%s] %s", get_class($e), $e->getMessage()), null, $e);
        }
        
        if ($response->isError()) {
            throw PerunErrorException::createFromResponse($response);
        }
        
        return $this->getEntityFactory()->createFromResponsePayload($response->getPayload());
    }


    /**
     * The magic call handler intercepts all non-existent methods and treats them as remote manager calls.
     * 
     * @param string $methodName
     * @param array $arguments
     * @return EntityInterface|Collection
     */
    public function __call($methodName, array $arguments)
    {
        $arguments = array_merge(array(
            $methodName
        ), $arguments);
        
        $response = call_user_func_array(array(
            $this,
            'callMethod'
        ), $arguments);
        
        return $response;
    }


    /**
     * The method recursively traverses the parameters and turns all entities into arrays.
     * 
     * @param array $params
     * @return array
     */
    public function paramsToArray(array $params)
    {
        foreach ($params as $name => $value) {
            if (is_array($value)) {
                $params[$name] = $this->paramsToArray($value);
                continue;
            }
            
            if ($value instanceof EntityInterface) {
                $params[$name] = $value->getProperties();
                continue;
            }
        }
        
        return $params;
    }
}