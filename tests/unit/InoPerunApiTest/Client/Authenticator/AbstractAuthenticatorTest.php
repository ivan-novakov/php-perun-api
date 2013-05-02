<?php

namespace InoPerunApiTest\Client\Authenticator;


class AbstractAuthenticatorTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $options = array(
            'foo' => 'bar'
        );
        $authenticator = $this->getMockForAbstractClass('InoPerunApi\Client\Authenticator\AbstractAuthenticator', array(
            $options
        ));
        $this->assertSame($options, $authenticator->getOptions());
    }

    public function testSetOptions()
    {
        $options = array(
            'foo' => 'bar'
        );
        $authenticator = $this->getMockForAbstractClass('InoPerunApi\Client\Authenticator\AbstractAuthenticator');
        $this->assertEmpty($authenticator->getOptions());
        $authenticator->setOptions($options);
        $this->assertSame($options, $authenticator->getOptions());
    }

    public function testGetOption()
    {
        $options = array(
            'foo' => 'bar'
        );
        $authenticator = $this->getMockForAbstractClass('InoPerunApi\Client\Authenticator\AbstractAuthenticator');
        $authenticator->setOptions($options);
        $this->assertSame('bar', $authenticator->getOption('foo'));
    }

    public function testGetOptionDefault()
    {
        $authenticator = $this->getMockForAbstractClass('InoPerunApi\Client\Authenticator\AbstractAuthenticator');
        $this->assertSame('default', $authenticator->getOption('foo', 'default'));
    }

    public function testGetOptionThrowException()
    {
        $this->setExpectedException('InoPerunApi\Exception\MissingOptionException');
        
        $authenticator = $this->getMockForAbstractClass('InoPerunApi\Client\Authenticator\AbstractAuthenticator');
        $authenticator->getOption('foo', null, true);
    }
}