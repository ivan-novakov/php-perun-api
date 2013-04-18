<?php

namespace InoPerunApi\Client;


class RequestFactory
{

    /**
     * The payload factory.
     * @var PayloadFactory
     */
    protected $payloadFactory = null;


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
        if (! $this->payloadFactory instanceof PayloadFactory) {
            $this->payloadFactory = new PayloadFactory();
        }
        
        return $this->payloadFactory;
    }


    /**
     * Creates a Perun request.
     * 
     * @param string $managerName
     * @param string $methodName
     * @param array|Payload|null $payload
     * @param boolean $changeState
     * @return Request
     */
    public function createRequest($managerName, $methodName, $payload = null, $changeState = false)
    {
        if (! $payload instanceof Payload) {
            $payload = $this->getPayloadFactory()
                ->createPayload($payload);
        }
        
        return new Request($managerName, $methodName, $payload, $changeState);
    }
}