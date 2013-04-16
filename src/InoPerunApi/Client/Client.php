<?php

namespace InoPerunApi\Client;

use Zend\Http;
use InoPerunApi\Client\Serializer\SerializerInterface;
use InoPerunApi\Client\Authenticator\AuthenticatorInterface;


class Client
{

    /**
	 * Zend HTTP client.
	 * @var Http\Client
	 */
    protected $httpClient = null;

    /**
     * The serializer.
     * @var SerializerInterface
     */
    protected $serializer = null;

    /**
     * The authenticator.
     * 
     * @var AuthenticatorInterface
     */
    protected $authenticator = null;


    public function __construct(Http\Client $httpClient, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }


    /**
     * Sets the authenticator. 
     * 
     * @param AuthenticatorInterface $authenticator
     */
    public function setAuthenticator(AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
    }


    /**
     * Returns the authenticator.
     * 
     * @return AuthenticatorInterface
     */
    public function getAuthenticator()
    {
        return $this->authenticator;
    }


    public function sendRequest(Request $request, Response $response = null)
    {
        if (null === $response) {
            $response = new Response($response);
        }
        
        // configure http client
        // configure authentication
        // serialize request data
        // create http request
        // send http request
        // de-serialize response
        // check for error
        // set response
    }
}
