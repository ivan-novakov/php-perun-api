<?php

namespace InoPerunApiTest\Manager\Factory;

use InoPerunApi\Manager\Factory\GenericFactory;


class GenericFactoryTest extends \PHPUnit_Framework_TestCase
{

    protected $factory;


    function setUp()
    {
        $this->factory = new GenericFactory();
    }


    public function testConstructor()
    {
        $client = $this->getClientMock();
        $factory = new GenericFactory($client);
        $this->assertSame($client, $factory->getClient());
    }


    public function testGetClientWithException()
    {
        $this->setExpectedException('InoPerunApi\Exception\MissingDependencyException');
        
        $this->factory->getClient();
    }


    public function testSetClient()
    {
        $client = $this->getClientMock();
        $this->factory->setClient($client);
        $this->assertSame($client, $this->factory->getClient());
    }


    public function testSetSupportedManagers()
    {
        $managers = array(
            'foo',
            'bar'
        );
        
        $this->factory->setSupportedManagers($managers);
        $this->assertSame($managers, $this->factory->getSupportedManagers());
    }


    public function testIsSupportedManager()
    {
        $managerName = 'foo';
        
        $this->assertFalse($this->factory->isSupported($managerName));
        
        $this->factory->setSupportedManagers(array(
            'foo',
            'bar'
        ));
        
        $this->assertTrue($this->factory->isSupported($managerName));
    }


    public function testCreateManagerWithUnsupportedException()
    {
        $this->setExpectedException('InoPerunApi\Manager\Factory\Exception\UnsupportedManagerException');
        
        $this->factory->createManager('foo', $this->getClientMock());
    }


    public function testCreateManager()
    {
        $managerName = 'foo';
        
        $this->factory->setSupportedManagers(array(
            $managerName
        ));
        
        $manager = $this->factory->createManager($managerName, $this->getClientMock());
        $this->assertInstanceOf('InoPerunApi\Manager\GenericManager', $manager);
        $this->assertSame($managerName, $manager->getManagerName());
    }
    
    /*
     * 
     */
    protected function getClientMock()
    {
        $client = $this->getMockBuilder('InoPerunApi\Client\Client')
            ->disableOriginalConstructor()
            ->getMock();
        return $client;
    }
}