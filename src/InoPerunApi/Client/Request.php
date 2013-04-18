<?php

namespace InoPerunApi\Client;


class Request
{

    /**
     * The remote manager name.
     * 
     * @var string
     */
    protected $managerName = 'genericManager';

    /**
     * The remote method name.
     * 
     * @var string
     */
    protected $methodName = 'genericMethod';

    /**
     * The request payload.
     * 
     * @var Payload
     */
    protected $payload = null;

    /**
     * Indicates if the request changes the remote state.
     * 
     * @var boolean
     */
    protected $changeState = false;


    /**
     * Constructor.
     * 
     * @param string $managerName
     * @param string $methodName
     * @param array|Payload $payload
     * @param boolean $changeState
     */
    public function __construct($managerName, $methodName, Payload $payload, $changeState = false)
    {
        $this->setManagerName($managerName);
        $this->setMethodName($methodName);
        $this->setPayload($payload);
        $this->setChangeState($changeState);
    }


    public function setManagerName($managerName)
    {
        $this->managerName = $managerName;
    }


    public function getManagerName()
    {
        return $this->managerName;
    }


    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;
    }


    public function getMethodName()
    {
        return $this->methodName;
    }


    /**
     * Sets the request payload.
     * 
     * @param Payload $payload
     * @throws Exception\InvalidPayloadException
     */
    public function setPayload(Payload $payload)
    {
        $this->payload = $payload;
    }


    /**
     * Returns the request payload.
     * 
     * @return Payload
     */
    public function getPayload()
    {
        return $this->payload;
    }


    public function setChangeState($changeState)
    {
        $this->changeState = (boolean) $changeState;
    }


    public function getChangeState()
    {
        return $this->changeState;
    }


    public function isChangeState()
    {
        return $this->getChangeState();
    }
}