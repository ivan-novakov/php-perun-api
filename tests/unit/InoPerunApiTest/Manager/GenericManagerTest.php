<?php

namespace InoPerunApiTest\Manager;

use InoPerunApi\Manager\GenericManager;


class GenericManagerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var GenericManager
     */
    protected $manager;


    public function setUp()
    {
        $this->manager = new GenericManager($this->createClientMock());
    }


    public function testSetManagerName()
    {
        $managerName = 'fooManager';
        $this->manager->setManagerName($managerName);
        $this->assertSame($managerName, $this->manager->getManagerName());
    }


    public function testGetClient()
    {
        $this->assertInstanceOf('InoPerunApi\Client\Client', $this->manager->getClient());
    }


    public function testSetClient()
    {
        $client = $this->createClientMock();
        $this->manager->setClient($client);
        $this->assertSame($client, $this->manager->getClient());
    }


    public function testGetEntityFactory()
    {
        $this->assertInstanceOf('InoPerunApi\Entity\Factory\FactoryInterface', $this->manager->getEntityFactory());
    }


    public function testSetEntityFactory()
    {
        $entityFactory = $this->createEntityFactoryMock();
        $this->manager->setEntityFactory($entityFactory);
        $this->assertSame($entityFactory, $this->manager->getEntityFactory());
    }
    
    // ------------
    protected function createClientMock()
    {
        $client = $this->getMockBuilder('InoPerunApi\Client\Client')
            ->disableOriginalConstructor()
            ->getMock();
        
        return $client;
    }


    protected function createEntityFactoryMock()
    {
        $entityFactory = $this->getMock('InoPerunApi\Entity\Factory\FactoryInterface');
        
        return $entityFactory;
    }
}