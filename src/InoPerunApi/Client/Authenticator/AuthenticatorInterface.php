<?php

namespace InoPerunApi\Client\Authenticator;

use Zend\Http;


interface AuthenticatorInterface
{


    /**
     * Configures the authentication in the HTTP client.
     * 
     * @param Http\Client $httpClient
     */
    public function configureAuthentication(Http\Client $httpClient);
}