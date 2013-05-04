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


    public function testCallMethodWithClientRuntimeException()
    {
        $this->setExpectedException('InoPerunApi\Manager\Exception\ClientRuntimeException');
        
        $managerName = 'fooManager';
        $methodName = 'fooMethod';
        $params = array(
            'foo' => 'bar'
        );
        $changeState = true;
        
        $client = $this->createClientMock();
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($managerName, $methodName, $params, $changeState)
            ->will($this->throwException(new \Exception()));
        $this->manager->setClient($client);
        
        $this->manager->setManagerName($managerName);
        $this->manager->callMethod($methodName, $params, $changeState);
    }


    public function testCallMethodWithPerunError()
    {
        $this->setExpectedException('InoPerunApi\Manager\Exception\PerunErrorException');
        
        $managerName = 'fooManager';
        $methodName = 'fooMethod';
        $params = array(
            'foo' => 'bar'
        );
        $changeState = true;
        
        $response = $this->createResponseMock(true);
        
        $client = $this->createClientMock();
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($managerName, $methodName, $params, $changeState)
            ->will($this->returnValue($response));
        $this->manager->setClient($client);
        
        $this->manager->setManagerName($managerName);
        $this->manager->callMethod($methodName, $params, $changeState);
    }


    public function testCallMethod()
    {
        $managerName = 'fooManager';
        $methodName = 'fooMethod';
        $params = array(
            'foo' => 'bar'
        );
        $changeState = true;
        
        $payload = $this->getMock('InoPerunApi\Client\Payload');
        $response = $this->createResponseMock();
        $response->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($payload));
        
        $client = $this->createClientMock();
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($managerName, $methodName, $params, $changeState)
            ->will($this->returnValue($response));
        $this->manager->setClient($client);
        
        $entity = $this->getMock('InoPerunApi\Entity\EntityInterface');
        
        $entityFactory = $this->getMock('InoPerunApi\Entity\Factory\FactoryInterface');
        $entityFactory->expects($this->once())
            ->method('createFromResponsePayload')
            ->with($payload)
            ->will($this->returnValue($entity));
        $this->manager->setEntityFactory($entityFactory);
        
        $this->manager->setManagerName($managerName);
        $entity = $this->manager->callMethod($methodName, $params, $changeState);
    }


    public function testMagicCall()
    {
        $methodName = 'fooMethod';
        $params = array(
            'foo' => 'bar'
        );
        $changeState = true;
        
        $entity = $this->getMock('InoPerunApi\Entity\EntityInterface');
        
        $manager = $this->getMockBuilder('InoPerunApi\Manager\GenericManager')
            ->disableOriginalConstructor()
            ->setMethods(array(
            'callMethod'
        ))
            ->getMock();
        $manager->expects($this->once())
            ->method('callMethod')
            ->with($methodName, $params, $changeState)
            ->will($this->returnValue($entity));
        
        $resultEntity = $manager->$methodName($params, $changeState);
        
        $this->assertSame($entity, $resultEntity);
    }
    
    // ------------
    protected function createClientMock($response = null)
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


    protected function createResponseMock($isError = false)
    {
        $response = $this->getMockBuilder('InoPerunApi\Client\Response')
            ->disableOriginalConstructor()
            ->getMock();
        $response->expects($this->once())
            ->method('isError')
            ->will($this->returnValue($isError));
        
        return $response;
    }
}