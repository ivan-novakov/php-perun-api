<?php

namespace InoPerunApi\Manager\Exception;


class PerunErrorException extends \RuntimeException
{

    protected $errorId = null;

    protected $type = null;

    protected $errorInfo = null;

    protected $isPerunException = null;


    public function __construct($errorId, $type, $errorInfo, $isPerunException)
    {
        $this->errorId = $errorId;
        $this->type = $type;
        $this->errorInfo = $errorInfo;
        $this->isPerunException = (boolean) $isPerunException;
        
        parent::__construct(sprintf("Perun %s [%s]: %s (%s)", ($this->isPerunException) ? 'exception' : 'error', $this->errorId, $this->type, $this->errorInfo));
    }
}