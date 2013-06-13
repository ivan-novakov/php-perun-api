<?php

namespace InoPerunApiTest\Client\Authenticator;

use InoPerunApi\Client\Authenticator\ClientCertificate;


class ClientCertificateTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ClientCertificate;
     */
    protected $authenticator;


    public function setUp()
    {
        $this->authenticator = new ClientCertificate();
    }


    public function testConfigureClientWithNoKeyFile()
    {
        $this->setExpectedException('InoPerunApi\Exception\MissingOptionException');
        
        $client = $this->createHttpClientMock();
        $this->authenticator->configureClient($client);
    }


    public function testConfigureClientWithNoCrtFile()
    {
        $this->setExpectedException('InoPerunApi\Exception\MissingOptionException');
        
        $options = array(
            ClientCertificate::OPT_KEY_FILE => '/tmp/key.pem'
        );
        $this->authenticator->setOptions($options);
        $client = $this->createHttpClientMock();
        $this->authenticator->configureClient($client);
    }


    public function testConfigureClient()
    {
        $keyFile = '/tmp/key.pem';
        $crtFile = '/tmp/crt.pem';
        $keyPass = 'keypass';
        
        $options = array(
            ClientCertificate::OPT_KEY_FILE => $keyFile,
            ClientCertificate::OPT_CRT_FILE => $crtFile,
            ClientCertificate::OPT_KEY_PASS => $keyPass
        );
        
        $curlOptions = array(
            CURLOPT_SSLKEY => $keyFile,
            CURLOPT_SSLCERT => $crtFile,
            CURLOPT_SSLKEYPASSWD => $keyPass
        );
        
        $this->authenticator->setOptions($options);
        
        $client = $this->createHttpClientMock();
        $client->expects($this->once())
            ->method('setOptions')
            ->with(array(
            'curloptions' => $curlOptions
        ));
        
        $this->authenticator->configureClient($client);
    }


    protected function createHttpClientMock()
    {
        $client = $this->getMock('Zend\Http\Client');
        
        return $client;
    }
}