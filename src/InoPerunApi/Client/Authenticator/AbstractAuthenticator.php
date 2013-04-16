<?php

namespace InoPerunApi\Client\Authenticator;

use InoPerunApi\Exception as GeneralException;


abstract class AbstractAuthenticator implements AuthenticatorInterface
{

    /**
     * Options.
     *
     * @var array
     */
    protected $options = array();


    /**
     * Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->setOptions($options);
    }


    /**
     * Sets the options.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }


    /**
     * Returns the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * Returns the value of a specific option.
     *
     * @param string $name
     * @throws InoPerunApi\Exception\MissingOptionException
     * @return mixed null
     */
    public function getOption($name, $defaultValue = null, $throwException = false)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }
        
        if ($throwException) {
            throw new GeneralException\MissingOptionException($name);
        }
        
        return $defaultValue;
    }
}