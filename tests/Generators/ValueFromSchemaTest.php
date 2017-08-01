<?php

namespace JeneratorTest\Generators;

use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\Generators\ValueFromSchema;
use Jenerator\Generators\ValueFromSchemaInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use JeneratorTest\TestCase;
use Mockery;

class ValueFromSchemaTest extends TestCase
{
    protected function getInstance()
    {
        $accessor = Mockery::mock(JsonSchemaAccessorInterface::class);

        $accessorFactory = Mockery::mock(JsonSchemaAccessorFactoryInterface::class)
            ->shouldReceive('getJsonSchemaAccessor')
            ->andReturn($accessor)
            ->getMock();

        $generator = Mockery::mock()
            ->shouldReceive('getGeneratedFakeValue')
            ->andReturn('hi hi hi')
            ->getMock();

        $generatorFactory = Mockery::mock(GeneratorFactoryInterface::class)
            ->shouldReceive('getGenerator')
            ->andReturn($generator)
            ->getMock();


        return new ValueFromSchema($accessorFactory, $generatorFactory);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(ValueFromSchemaInterface::class, $this->getInstance());
    }

    public function testGetExampleValueFromSchema()
    {
        $instance = $this->getInstance();
        $actual = $instance->getExampleValueFromSchema(['some' => 'thing']);
        $this->assertEquals('hi hi hi', $actual);
    }
}