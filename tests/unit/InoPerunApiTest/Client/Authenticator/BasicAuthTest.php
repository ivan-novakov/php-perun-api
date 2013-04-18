<?php

namespace InoPerunApiTest\Client\Authenticator;

use InoPerunApi\Client\Authenticator\BasicAuth;


class BasicAuthTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var BasicAuth
     */
    protected $authenticator = null;


    public function setUp()
    {
        $this->authenticator = new BasicAuth();
    }


    public function testConfigureRequestWithNoAuthorization()
    {
        $this->setExpectedException('InoPerunApi\Exception\MissingOptionException');
        
        $httpRequest = $this->getMock('Zend\Http\Request');
        $this->authenticator->configureRequest($httpRequest);
    }


    public function testConfigure()
    {
        $authString = 'auth_string';
        
        $this->authenticator->setOptions(array(
            BasicAuth::OPT_AUTHORIZATION => $authString
        ));
        
        $httpRequest = new \Zend\Http\Request();
        $this->authenticator->configureRequest($httpRequest);
        $this->assertSame($authString, $httpRequest->getHeader('Authorization')
            ->getFieldValue());
    }


    public function testConfigureWithCookie()
    {
        $authString = 'auth_string';
        $cookieName = 'name';
        $cookieValue = 'value';
        
        $this->authenticator->setOptions(array(
            BasicAuth::OPT_AUTHORIZATION => $authString, 
            BasicAuth::OPT_COOKIE_NAME => $cookieName, 
            BasicAuth::OPT_COOKIE_VALUE => $cookieValue
        ));
        
        $httpRequest = new \Zend\Http\Request();
        $this->authenticator->configureRequest($httpRequest);
        
        $expectedValue = sprintf("%s=%s", $cookieName, $cookieValue);
        $this->assertSame($expectedValue, $httpRequest->getHeader('Cookie')
            ->getFieldValue());
    }
}