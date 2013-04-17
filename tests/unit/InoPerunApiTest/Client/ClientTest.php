<?php

namespace InoPerunApiTest\Client;

use InoPerunApi\Client\Client;


class ClientTest extends \PHPUnit_Framework_TestCase
{
    
    /*
    public function testConstructor()
    {
        $options = array();
        
        $client = $this->getMock('InoPerunApi\Client\Client', array(
            'setOptions'
        ), array(
            $options, 
            $this->createHttpClientMock(), 
            $this->createSerializerMock()
        ));
        
        $client->expects($this->once())
            ->method('setOptions')
            ->with($options);
    }
    */
    public function testSetOptions()
    {
        $options = array(
            'url' => 'testurl'
        );
        $client = $this->createClient();
        $client->setOptions($options);
        $this->assertSame($options, $client->getOptions()
            ->toArray());
    }


    public function testSetHttpRequestFactory()
    {
        $client = $this->createClient();
        $httpRequestFactory = $this->createHttpRequestFactoryMock();
        $client->setHttpRequestFactory($httpRequestFactory);
        $this->assertSame($httpRequestFactory, $client->getHttpRequestFactory());
    }


    public function testSetAuthenticator()
    {
        $authenticator = $this->createAuthenticatorMock();
        $client = $this->createClient();
        $client->setAuthenticator($authenticator);
        $this->assertSame($authenticator, $client->getAuthenticator());
    }


    /**
     * @return Client
     */
    protected function createClient()
    {
        $client = new Client(null, $this->createHttpClientMock(), $this->createSerializerMock());
        
        return $client;
    }


    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createHttpClientMock()
    {
        $httpClient = $this->getMock('Zend\Http\Client');
        
        return $httpClient;
    }


    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createSerializerMock()
    {
        $serializer = $this->getMock('InoPerunApi\Client\Serializer\SerializerInterface');
        
        return $serializer;
    }


    protected function createAuthenticatorMock()
    {
        $authenticator = $this->getMock('InoPerunApi\Client\Authenticator\AuthenticatorInterface');
        
        return $authenticator;
    }


    protected function createHttpRequestFactoryMock()
    {
        $httpRequestFactory = $this->getMockBuilder('InoPerunApi\Client\Http\RequestFactory')
            ->disableOriginalConstructor()
            ->getMock();
        
        return $httpRequestFactory;
    }
}