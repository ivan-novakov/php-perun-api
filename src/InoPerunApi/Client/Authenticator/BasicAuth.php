<?php

namespace InoPerunApi\Client\Authenticator;

use Zend\Http;
use Zend\Http\Header\Cookie;


class BasicAuth extends AbstractAuthenticator
{

    const OPT_AUTHORIZATION = 'authorization';

    const OPT_COOKIE_NAME = 'cookie_name';

    const OPT_COOKIE_VALUE = 'cookie_value';


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Client\Authenticator\AuthenticatorInterface::configureRequest()
     */
    public function configureRequest(\Zend\Http\Request $httpRequest)
    {
        $headers = array();
        
        $authorizationString = $this->getOption(self::OPT_AUTHORIZATION, null, true);
        $headers[] = array(
            'Authorization' => $authorizationString
        );
        
        if (($cookieName = $this->getOption(self::OPT_COOKIE_NAME)) &&
             ($cookieValue = $this->getOption(self::OPT_COOKIE_VALUE))) {
            $headers[] = new Cookie(array(
                $cookieName => $cookieValue
            ));
        }
        
        $httpRequest->getHeaders()
            ->addHeaders($headers);
    }
}