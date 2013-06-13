<?php

namespace InoPerunApi\Client\Authenticator;

use Zend\Http;


class ClientCertificate extends AbstractAuthenticator implements ClientAuthenticatorInterface
{

    const OPT_KEY_FILE = 'key_file';

    const OPT_CRT_FILE = 'crt_file';

    const OPT_KEY_PASS = 'key_pass';


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Client\Authenticator\ClientAuthenticatorInterface::configureClient()
     */
    public function configureClient(Http\Client $httpClient)
    {
        $keyFile = $this->getOption(self::OPT_KEY_FILE, null, true);
        $crtFile = $this->getOption(self::OPT_CRT_FILE, null, true);
        $keyPass = $this->getOption(self::OPT_KEY_PASS);
        
        $httpClient->setOptions(array(
            'curloptions' => array(
                CURLOPT_SSLKEY => $keyFile,
                CURLOPT_SSLCERT => $crtFile,
                CURLOPT_SSLKEYPASSWD => $keyPass
            )
        ));
    }
}