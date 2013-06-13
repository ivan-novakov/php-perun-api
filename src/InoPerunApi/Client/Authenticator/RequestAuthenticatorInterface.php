<?php

namespace InoPerunApi\Client\Authenticator;

use Zend\Http;


/**
 * Configures the client authentication on the HTTP request.
 */
interface RequestAuthenticatorInterface extends AuthenticatorInterface
{


    /**
     * @param Http\Request $httpRequest
     */
    public function configureRequest(Http\Request $httpRequest);
}

