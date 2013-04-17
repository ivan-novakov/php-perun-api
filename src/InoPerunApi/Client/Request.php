<?php

namespace InoPerunApi\Client;


class Request
{

    /**
     * The payload factory.
     * 
     * @var PayloadFactory
     */
    protected $payloadFactory = null;

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
    public function __construct($managerName = null, $methodName = null, $payload = null, $changeState = false)
    {
        if (null !== $managerName) {
            $this->setManagerName($managerName);
        }
        
        if (null !== $methodName) {
            $this->setMethodName($methodName);
        }
        
        $this->setPayload($payload);
        $this->setChangeState($changeState);
    }


    /**
     * Sets the payload factory.
     * 
     * @param PayloadFactory $payloadFactory
     */
    public function setPayloadFactory(PayloadFactory $payloadFactory)
    {
        $this->payloadFactory = $payloadFactory;
    }


    /**
     * Returns the payload factory.
     * 
     * @return PayloadFactory
     */
    public function getPayloadFactory()
    {
        if (! ($this->payloadFactory instanceof PayloadFactory)) {
            $this->payloadFactory = new PayloadFactory();
        }
        
        return $this->payloadFactory;
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
     * @param array|Payload|null $payload
     * @throws Exception\InvalidPayloadException
     */
    public function setPayload($payload)
    {
        if ($payload instanceof Payload) {
            $this->payload = $payload;
        } else {
            $this->payload = $this->getPayloadFactory()
                ->createPayload($payload);
        }
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