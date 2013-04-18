<?php

namespace InoPerunApiTest\Util;

use InoPerunApi\Util\GenericFactory;


class GenericFactoryTest extends \PHPUnit_Framework_TestCase
{

    protected $factory = null;


    public function setUp()
    {
        $this->factory = new GenericFactory();
    }


    public function testFactoryWithNoClass()
    {
        $this->setExpectedException('InoPerunApi\Exception\MissingOptionException');
        
        $this->factory->factory(array());
    }


    public function testFactoryWithNonExistentClass()
    {
        $this->setExpectedException('InoPerunApi\Exception\ClassNotFoundException');
        
        $this->factory->factory(array(
            GenericFactory::OPT_CLASS => '__NonExistentClass'
        ));
    }


    public function testFactory()
    {
        include TESTS_ROOT_DIR . '/data/__TestClass.php';
        
        $options = array(
            'foo' => 'bar'
        );
        
        $object = $this->factory->factory(array(
            GenericFactory::OPT_CLASS => '__TestClass', 
            GenericFactory::OPT_OPTIONS => $options
        ));
        
        $this->assertInstanceOf('__TestClass', $object);
        $this->assertSame($options, $object->getOptions());
    }
}