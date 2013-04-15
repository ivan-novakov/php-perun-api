<?php

namespace InoPerunApi\Client;


class Response
{

    /**
     * The corresponding request.
     * 
     * @var Request
     */
    protected $request = null;

    /**
     * The payload of the response, if present.
     * 
     * @var Payload
     */
    protected $payload = null;

    /**
     * The error, contained in the response, if present.
     * 
     * @var Error
     */
    protected $error = null;


    /**
     * Constructor.
     * 
     * @param Request $request
     * @param Payload $payload
     * @param Error $error
     */
    public function __construct(Request $request, Payload $payload = null, Error $error = null)
    {
        $this->request = $request;
        
        if (null !== $payload) {
            $this->setPayload($payload);
        }
        
        if (null !== $error) {
            $this->setError($error);
        }
    }


    /**
     * Returns the corresponding request.
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }


    /**
     * Sets the response payload.
     * 
     * @param Payload $payload
     */
    public function setPayload(Payload $payload)
    {
        $this->payload = $payload;
    }


    /**
     * Returns the response payload.
     * 
     * @return Payload
     */
    public function getPayload()
    {
        return $this->payload;
    }


    /**
     * Sets the response error.
     * @param Error $error
     */
    public function setError(Error $error)
    {
        $this->error = $error;
    }


    /**
     * Returns the response error.
     * 
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }


    /**
     * Returns true, if there is an error.
     * 
     * @return boolean
     */
    public function isError()
    {
        return (null !== $this->getError());
    }
}