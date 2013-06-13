<?php

namespace InoPerunApi\Client\Authenticator;

use Zend\Http;


/**
 * Configures the client authentication on the HTTP client.
 */
interface ClientAuthenticatorInterface extends AuthenticatorInterface
{


    /**
     * @param Http\Client $httpClient
     */
    public function configureClient(Http\Client $httpClient);
}

