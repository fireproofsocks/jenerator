<?php

namespace JeneratorTest\Generators;

use Jenerator\Generators\GeneratorFactory;
use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\ServiceContainer;
use JeneratorTest\TestCase;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class GeneratorFactoryTest extends TestCase
{
    protected function getInstance()
    {

        $container = new ServiceContainer();
        $container->register(new TestGeneratorServiceProvider());
        return new GeneratorFactory($container);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorFactoryInterface::class, $this->getInstance());
    }
    
    public function testGetEnumGenerator()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGenerator($this->getSchemaAccessor(['enum' => ['x','y','z']]));
        $this->assertEquals('enum', $actual);
    }

    public function testTypeIsSingleValue()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGenerator($this->getSchemaAccessor(['type' => 'string']));
        $this->assertEquals('string', $actual);
    }

    /**
     * @expectedException \Jenerator\Exceptions\InvalidTypeException
     */
    public function testInvalidDataTypeThrowsException()
    {
        $instance = $this->getInstance();
        $instance->getGenerator($this->getSchemaAccessor(['type' => 'bogus']));
    }

    public function testNoTypeDefinedResultsInRandomResult()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGenerator($this->getSchemaAccessor([]));
        $this->assertTrue(in_array($actual, ['object', 'array', 'string', 'number', 'integer', 'boolean', 'null']));
    }

    public function testArrayOfTypesDefined()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGenerator($this->getSchemaAccessor(['type' => ['string', 'null']]));
        $this->assertTrue(in_array($actual, ['string', 'null']));
    }
}

class TestGeneratorServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $container)
    {
        $container['generator_enum'] = function () {
            return 'enum';
        };
        $container['generator_object'] = function ($c) {
            return 'object';
        };
        $container['generator_array'] = function ($c) {
            return 'array';
        };
        $container['generator_string'] = function ($c) {
            return 'string';
        };
        $container['generator_number'] = function ($c) {
            return 'number';
        };
        $container['generator_integer'] = function ($c) {
            return 'number';
        };
        $container['generator_boolean'] = function () {
            return 'boolean';
        };
        $container['generator_null'] = function () {
            return 'null';
        };
    }

}