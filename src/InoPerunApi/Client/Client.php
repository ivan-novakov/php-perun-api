<?php

namespace InoPerunApi\Client;

use InoPerunApi\Client\Http;
use InoPerunApi\Client\Serializer\SerializerInterface;
use InoPerunApi\Client\Authenticator\AuthenticatorInterface;
use Zend\Http\Header\Cookie;


class Client
{

    /**
	 * Zend HTTP client.
	 * @var \Zend\Http\Client
	 */
    protected $httpClient = null;

    /**
	 * The serializer.
	 * @var SerializerInterface
	 */
    protected $serializer = null;

    /**
	 * The HTTP request factory.
	 * 
	 * @var Http\RequestFactory
	 */
    protected $httpRequestFactory = null;

    /**
     * The Perun request factory.
     * 
     * @var RequestFactory
     */
    protected $requestFactory = null;

    /**
     * The Perun response factory.
     * 
     * @var ResponseFactory
     */
    protected $responseFactory = null;

    /**
	 * The authenticator.
	 * 
	 * @var AuthenticatorInterface
	 */
    protected $authenticator = null;


    public function __construct($options,\Zend\Http\Client $httpClient, SerializerInterface $serializer)
    {
        $this->setOptions($options);
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }


    /**
	 * Sets the client options.
	 * 
	 * @param array|\Traversable|ClientOptions $options
	 */
    public function setOptions($options)
    {
        if (! $options instanceof ClientOptions) {
            $options = new ClientOptions($options);
        }
        
        $this->options = $options;
    }


    /**
	 * Returns the client options.
	 * 
	 * @return ClientOptions
	 */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * Returns the HTTP client.
     * 
     * @return \Zend\Http\Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }


    /**
     * Sets the HTTP request factory.
     * 
	 * @param Http\RequestFactory $httpRequestFactory
	 */
    public function setHttpRequestFactory($httpRequestFactory)
    {
        $this->httpRequestFactory = $httpRequestFactory;
    }


    /**
	 * Returns the HTTP request factory.
	 *
	 * @return Http\RequestFactory
	 */
    public function getHttpRequestFactory()
    {
        if (! $this->httpRequestFactory instanceof Http\RequestFactory) {
            $this->httpRequestFactory = new Http\RequestFactory($this->serializer);
        }
        return $this->httpRequestFactory;
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


    /**
     * Sets the Perun response factory.
     * 
     * @param ResponseFactory $responseFactory
     */
    public function setResponseFactory(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }


    /**
     * Returns the Perun response factory.
     * 
     * @return ResponseFactory
     */
    public function getResponseFactory()
    {
        if (! $this->responseFactory instanceof ResponseFactory) {
            $this->responseFactory = new ResponseFactory();
            $this->responseFactory->setSerializer($this->serializer);
        }
        
        return $this->responseFactory;
    }


    /**
     * Sets the Perun request factory.
     * 
     * @param RequestFactory $requestFactory
     */
    public function setRequestFactory(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }


    /**
     * Returns the Perun request factory.
     * 
     * @return RequestFactory
     */
    public function getRequestFactory()
    {
        if (! $this->requestFactory instanceof RequestFactory) {
            $this->requestFactory = new RequestFactory();
        }
        return $this->requestFactory;
    }


    public function send(Request $request)
    {
        $httpRequest = $this->getHttpRequestFactory()
            ->createRequest($this->options->getUrl(), $request);
        
        if ($this->authenticator instanceof AuthenticatorInterface) {
            $this->authenticator->configureRequest($httpRequest);
        }
        
        try {
            $httpResponse = $this->httpClient->send($httpRequest);
        } catch (\Exception $e) {
            /*
             * Connection exception
             */
            _dump("$e");
        }
        
        if ($httpResponse->getStatusCode() != 200) {}
        
        return $this->getResponseFactory()
            ->createResponseFromHttpResponse($httpResponse, $request);
    }


    public function sendRequest($managerName, $methodName, array $params = array(), $changeState = false)
    {
        $request = $this->getRequestFactory()
            ->createRequest($managerName, $methodName, $params, $changeState);
        
        return $this->send($request);
    }
}
