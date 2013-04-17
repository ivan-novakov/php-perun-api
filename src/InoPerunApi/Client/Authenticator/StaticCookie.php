<?php

namespace InoPerunApi\Client\Authenticator;

use Zend\Http\Client;


class StaticCookie extends AbstractAuthenticator
{

    const OPT_COOKIE_NAME = 'cookie_name';

    const OPT_COOKIE_VALUE = 'cookie_value';


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Client\Authenticator\AuthenticatorInterface::configureAuthentication()
     */
    public function configureAuthentication(Client $httpClient)
    {
        $cookieName = $this->getOption(self::OPT_COOKIE_NAME, null, true);
        $cookieValue = $this->getOption(self::OPT_COOKIE_VALUE, null, true);
        
        $httpClient->addCookie($cookieName, $cookieValue);
    }
}