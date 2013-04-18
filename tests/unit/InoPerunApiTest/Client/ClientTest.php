<?php

namespace InoPerunApiTest\Client;

use InoPerunApi\Client\Client;


class ClientTest extends \PHPUnit_Framework_TestCase
{


    public function testConstructor()
    {
        $options = array();
        
        $client = $this->getMockBuilder('InoPerunApi\Client\Client')
            ->setMethods(array(
            'setOptions'
        ))
            ->disableOriginalConstructor()
            ->getMock();
        
        $client->expects($this->once())
            ->method('setOptions')
            ->with($options);
        
        $client->__construct($options, $this->createHttpClientMock(), $this->createSerializerMock());
    }


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


    public function testGetHttpClient()
    {
        $httpClient = $this->createHttpClientMock();
        $client = new Client(null, $httpClient, $this->createSerializerMock());
        $this->assertSame($httpClient, $client->getHttpClient());
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


    public function testSendWithConnectionException()
    {
        $this->setExpectedException('InoPerunApi\Client\Exception\ConnectionException');
        
        $url = 'https://api.example.org/rest';
        $options = $this->getMock('InoPerunApi\Client\ClientOptions');
        $options->expects($this->once())
            ->method('getUrl')
            ->will($this->returnValue($url));
        
        $request = $this->createRequestMock();
        
        $httpRequest = $this->createHttpRequestMock();
        
        $httpRequestFactory = $this->createHttpRequestFactoryMock($httpRequest, $request, $url);
        
        $authenticator = $this->createAuthenticatorMock($httpRequest);
        
        $httpClient = $this->createHttpClientMock();
        $httpClient->expects($this->once())
            ->method('send')
            ->with($httpRequest)
            ->will($this->throwException(new \Exception()));
        
        $client = $this->createClient($options, $httpClient);
        $client->setOptions($options);
        $client->setHttpRequestFactory($httpRequestFactory);
        $client->setAuthenticator($authenticator);
        
        $response = $client->send($request);
    }


    public function testSendWithInvalidResponse()
    {
        $this->setExpectedException('InoPerunApi\Client\Exception\InvalidResponseException');
        
        $url = 'https://api.example.org/rest';
        $options = $this->getMock('InoPerunApi\Client\ClientOptions');
        $options->expects($this->once())
            ->method('getUrl')
            ->will($this->returnValue($url));
        
        $request = $this->createRequestMock();
        
        $httpRequest = $this->createHttpRequestMock();
        $httpResponse = $this->createHttpResponseMock(400);
        
        $httpRequestFactory = $this->createHttpRequestFactoryMock($httpRequest, $request, $url);
        
        $authenticator = $this->createAuthenticatorMock($httpRequest);
        
        $httpClient = $this->createHttpClientMock();
        $httpClient->expects($this->once())
            ->method('send')
            ->with($httpRequest)
            ->will($this->returnValue($httpResponse));
        
        $client = $this->createClient($options, $httpClient);
        $client->setOptions($options);
        $client->setHttpRequestFactory($httpRequestFactory);
        $client->setAuthenticator($authenticator);
        
        $response = $client->send($request);
    }


    public function testSendOk()
    {
        $url = 'https://api.example.org/rest';
        $options = $this->getMock('InoPerunApi\Client\ClientOptions');
        $options->expects($this->once())
            ->method('getUrl')
            ->will($this->returnValue($url));
        
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        
        $httpRequest = $this->createHttpRequestMock();
        $httpResponse = $this->createHttpResponseMock();
        
        $httpRequestFactory = $this->createHttpRequestFactoryMock($httpRequest, $request, $url);
        
        $authenticator = $this->createAuthenticatorMock($httpRequest);
        
        $httpClient = $this->createHttpClientMock();
        $httpClient->expects($this->once())
            ->method('send')
            ->with($httpRequest)
            ->will($this->returnValue($httpResponse));
        
        $responseFactory = $this->getMock('InoPerunApi\Client\ResponseFactory');
        $responseFactory->expects($this->once())
            ->method('createResponseFromHttpResponse')
            ->with($httpResponse, $request)
            ->will($this->returnValue($response));
        
        $client = $this->createClient($options, $httpClient);
        $client->setOptions($options);
        $client->setHttpRequestFactory($httpRequestFactory);
        $client->setAuthenticator($authenticator);
        $client->setResponseFactory($responseFactory);
        
        $returnedResponse = $client->send($request);
        $this->assertSame($returnedResponse, $response);
    }


    public function testSendRequest()
    {
        $managerName = 'fooManager';
        $methodName = 'barMethod';
        $params = array(
            'foo' => 'bar'
        );
        //$payload = $this->getMock('InoPerunApi\Client\Payload');
        $changeState = true;
        
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        
        $requestFactory = $this->getMock('InoPerunApi\Client\RequestFactory');
        $requestFactory->expects($this->once())
            ->method('createRequest')
            ->with($managerName, $methodName, $params, $changeState)
            ->will($this->returnValue($request));
        
        $client = $this->getMockBuilder('InoPerunApi\Client\Client')
            ->setMethods(array(
            'send'
        ))
            ->disableOriginalConstructor()
            ->getMock();
        
        $client->setRequestFactory($requestFactory);
        
        $client->expects($this->once())
            ->method('send')
            ->with($request)
            ->will($this->returnValue($response));
        
        $response = $client->sendRequest($managerName, $methodName, $params, $changeState);
    }


    /**
     * @return Client
     */
    protected function createClient($options = null, $httpClient = null, $serializer = null)
    {
        if (null === $httpClient) {
            $httpClient = $this->createHttpClientMock();
        }
        if (null == $serializer) {
            $serializer = $this->createSerializerMock();
        }
        $client = new Client(null, $httpClient, $serializer);
        
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


    public function createHttpResponseMock($status = 200)
    {
        $httpResponse = $this->getMock('Zend\Http\Response');
        $httpResponse->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue($status));
        
        return $httpResponse;
    }


    protected function createHttpRequestMock()
    {
        $httpRequest = $this->getMock('Zend\Http\Request');
        
        return $httpRequest;
    }


    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createSerializerMock()
    {
        $serializer = $this->getMock('InoPerunApi\Client\Serializer\SerializerInterface');
        
        return $serializer;
    }


    protected function createAuthenticatorMock($httpRequest = null)
    {
        $authenticator = $this->getMock('InoPerunApi\Client\Authenticator\AuthenticatorInterface');
        if ($httpRequest) {
            $authenticator->expects($this->once())
                ->method('configureRequest')
                ->with($httpRequest);
        }
        
        return $authenticator;
    }


    protected function createHttpRequestFactoryMock($httpRequest = null, $request = null, $url = null)
    {
        $httpRequestFactory = $this->getMockBuilder('InoPerunApi\Client\Http\RequestFactory')
            ->disableOriginalConstructor()
            ->getMock();
        
        if ($httpRequest && $request && $url) {
            $httpRequestFactory->expects($this->once())
                ->method('createRequest')
                ->with($url, $request)
                ->will($this->returnValue($httpRequest));
        }
        
        return $httpRequestFactory;
    }


    protected function createRequestMock()
    {
        $request = $this->getMockBuilder('InoPerunApi\Client\Request')
            ->disableOriginalConstructor()
            ->getMock();
        
        return $request;
    }


    protected function createResponseMock()
    {
        $response = $this->getMockBuilder('InoPerunApi\Client\Response')
            ->disableOriginalConstructor()
            ->getMock();
        
        return $response;
    }
}