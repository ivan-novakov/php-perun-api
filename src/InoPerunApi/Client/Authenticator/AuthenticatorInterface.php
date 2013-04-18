<?php

namespace InoPerunApi\Client\Authenticator;

use Zend\Http;


interface AuthenticatorInterface
{


    /**
     * Configures authentication on the HTTP request.
     * 
     * @param Http\Request $httpRequest
     */
    public function configureRequest(Http\Request $httpRequest);
}