<?php

namespace InoPerunApi\Client;


class Response
{

    const PARAM_ERROR_ID = 'errorId';

    const PARAM_ERROR_TYPE = 'type';

    const PARAM_ERROR_INFO = 'errorInfo';

    const PARAM_ERROR_MESSAGE = 'message';

    const PARAM_ERROR_NAME = 'name';

    const PARAM_ERROR_IS_PERUN_EXCEPTION = 'isPerunException';

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
     * Constructor.
     * 
     * @param Request $request
     * @param Payload $payload
     */
    public function __construct(Request $request, Payload $payload)
    {
        $this->request = $request;
        $this->setPayload($payload);
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
     * Returns true, if there is an error.
     * 
     * @return boolean
     */
    public function isError()
    {
        return (null !== $this->getErrorId());
    }


    /**
     * Returns the response error ID, if present.
     *
     * @return string|null
     */
    public function getErrorId()
    {
        return $this->payload->getParam(self::PARAM_ERROR_ID);
    }


    /**
     * Returns the error type, if present.
     * 
     * @return string|null
     */
    public function getErrorType()
    {
        return $this->payload->getParam(self::PARAM_ERROR_TYPE);
    }


    /**
     * Returns the error message, if present.
     * 
     * @return string|null
     */
    public function getErrorMessage()
    {
        return $this->payload->getParam(self::PARAM_ERROR_MESSAGE);
    }


    /**
     * Returns the error info, if present.
     * 
     * @return string|null
     */
    public function getErrorInfo()
    {
        return $this->payload->getParam(self::PARAM_ERROR_INFO);
    }


    /**
     * Returns the error name, if present.
     * 
     * @return string|null
     */
    public function getErrorName()
    {
        return $this->payload->getParam(self::PARAM_ERROR_NAME);
    }


    /**
     * Returns true, if the error response is a Perun exception.
     * 
     * @return boolean
     */
    public function isPerunException()
    {
        $isPerunException = $this->payload->getParam(self::PARAM_ERROR_IS_PERUN_EXCEPTION);
        if ($isPerunException && $isPerunException == 'true') {
            return true;
        }
        
        return false;
    }


    /**
     * Returns all information about the error.
     * 
     * @return array
     */
    public function getErrorData()
    {
        return array(
            'id' => $this->getErrorId(),
            'name' => $this->getErrorName(),
            'type' => $this->getErrorType(),
            'message' => $this->getErrorMessage(),
            'info' => $this->getErrorInfo(),
            'perunException' => $this->isPerunException()
        );
    }
}