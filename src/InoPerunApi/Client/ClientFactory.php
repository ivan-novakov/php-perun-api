<?php

namespace InoPerunApi\Client;

use InoPerunApi\Client\Serializer\SerializerInterface;
use InoPerunApi\Client\Authenticator\AuthenticatorInterface;
use InoPerunApi\Util\GenericFactory;
use InoPerunApi\Exception as CommonException;


class ClientFactory
{

    const OPT_HTTP_CLIENT = 'http_client';

    const OPT_CLIENT = 'client';

    const OPT_AUTHENTICATOR = 'authenticator';

    const OPT_SERIALIZER = 'serializer';

    /**
     * Generic factory.
     * 
     * @var GenericFactory
     */
    protected $genericFactory = null;

    /**
     * Default serializer configuration.
     * 
     * @var array
     */
    protected $defaultSerializerConfig = array(
        'class' => 'InoPerunApi\Client\Serializer\Json'
    );


    /**
     * Creates and returns the Perun client.
     * 
     * @param array $config
     * @throws CommonException\MissingOptionException
     * @return Client
     */
    public function createClient(array $config = array())
    {
        if (! isset($config[self::OPT_CLIENT])) {
            throw new CommonException\MissingOptionException(self::OPT_CLIENT);
        }
        
        $httpClient = $this->createHttpClient($config);
        $serializer = $this->createSerializer($config);
        $authenticator = $this->createAuthenticator($config);
        
        $client = new Client($config[self::OPT_CLIENT], $httpClient, $serializer);
        $client->setAuthenticator($authenticator);
        
        return $client;
    }


    /**
     * Creates and returns the HTTP client.
     * 
     * @param array $config
     * @throws CommonException\MissingOptionException
     * @return \Zend\Http\Client
     */
    public function createHttpClient(array $config = array())
    {
        if (! isset($config[self::OPT_HTTP_CLIENT])) {
            throw new CommonException\MissingOptionException(self::OPT_HTTP_CLIENT);
        }
        
        $httpClientFactory = new Http\ClientFactory();
        return $httpClientFactory->createClient($config[self::OPT_HTTP_CLIENT]);
    }


    /**
     * Creates and returns the corresponding authenicator.
     * 
     * @param array $config
     * @throws CommonException\MissingOptionException
     * @return AuthenticatorInterface
     */
    public function createAuthenticator(array $config = array())
    {
        if (! isset($config[self::OPT_AUTHENTICATOR])) {
            throw new CommonException\MissingOptionException(self::OPT_AUTHENTICATOR);
        }
        
        return $this->getGenericFactory()
            ->factory($config[self::OPT_AUTHENTICATOR]);
    }


    /**
     * Creates and returns the corresponding serializer.
     * 
     * @param array $config
     * @return SerializerInterface
     */
    public function createSerializer(array $config = array())
    {
        $serializerConfig = $this->defaultSerializerConfig;
        if (isset($config[self::OPT_SERIALIZER]) && is_array($config[self::OPT_SERIALIZER])) {
            $serializerConfig = $config[self::OPT_SERIALIZER];
        }
        
        return $this->getGenericFactory()
            ->factory($serializerConfig);
    }


    /**
     * Returns the generic factory.
     * 
     * @return GenericFactory
     */
    public function getGenericFactory()
    {
        if (! $this->genericFactory instanceof GenericFactory) {
            $this->genericFactory = new GenericFactory();
        }
        
        return $this->genericFactory;
    }
}