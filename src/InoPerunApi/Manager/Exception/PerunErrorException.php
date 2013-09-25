<?php

namespace InoPerunApi\Manager\Exception;

use InoPerunApi\Client\Response;


/**
 * Exception indicating a Perun error.
 */
class PerunErrorException extends \RuntimeException
{

    /**
     * @var string
     */
    protected $errorId;

    /**
     * @var string
     */
    protected $errorName;

    /**
     * @var string
     */
    protected $errorType;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * @var string
     */
    protected $errorInfo;

    /**
     * @var boolean
     */
    protected $isPerunException;


    /**
     * Alternative constructor.
     * 
     * @param Response $response
     * @return PerunErrorException
     */
    static public function createFromResponse(Response $response)
    {
        $e = new self();
        $e->setErrorFromResponse($response);
        
        return $e;
    }


    /**
     * Sets the exception error info from the Perun response.
     * 
     * @param Response $response
     */
    public function setErrorFromResponse(Response $response)
    {
        $this->setErrorId($response->getErrorId());
        $this->setErrorName($response->getErrorName());
        $this->setErrorType($response->getErrorType());
        $this->setErrorInfo($response->getErrorInfo());
        $this->setErrorMessage($response->getErrorMessage());
        $this->setPerunException($response->isPerunException());
        
        $this->message = sprintf("Perun %s [%s]: [%s] %s (%s)", ($this->isPerunException()) ? 'exception' : 'error', 
            $this->getErrorId(), $this->getErrorName(), $this->getErrorMessage(), $this->getErrorInfo());
    }


    /**
     * @return string
     */
    public function getErrorId()
    {
        return $this->errorId;
    }


    /**
     * @param string $errorId
     */
    public function setErrorId($errorId)
    {
        $this->errorId = $errorId;
    }


    /**
     * @return string
     */
    public function getErrorName()
    {
        return $this->errorName;
    }


    /**
     * @param string $errorName
     */
    public function setErrorName($errorName)
    {
        $this->errorName = $errorName;
    }


    /**
     * @return string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }


    /**
     * @param string $errorType
     */
    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;
    }


    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }


    /**
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }


    /**
     * @return string
     */
    public function getErrorInfo()
    {
        return $this->errorInfo;
    }


    /**
     * @param string $errorInfo
     */
    public function setErrorInfo($errorInfo)
    {
        $this->errorInfo = $errorInfo;
    }


    /**
     * @return boolean
     */
    public function isPerunException()
    {
        return $this->isPerunException;
    }


    /**
     * @param boolean $isPerunException
     */
    public function setPerunException($isPerunException)
    {
        $this->isPerunException = (boolean) $isPerunException;
    }
}