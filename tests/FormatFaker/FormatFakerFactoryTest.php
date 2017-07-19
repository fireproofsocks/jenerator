<?php

namespace JeneratorTest\FormatFaker;


use Jenerator\FormatFaker\FormatFakerFactory;
use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ServiceContainerInterface;
use JeneratorTest\TestCase;
use Mockery;

class FormatFakerFactoryTest extends TestCase
{
    public function testInstantiation()
    {
        $container = Mockery::mock(ServiceContainerInterface::class)
            ->shouldReceive('make')
            ->andReturn(function() { return 'hi'; })
            ->getMock();
        $instance = new FormatFakerFactory($container);

        $this->assertInstanceOf(FormatFakerFactoryInterface::class, $instance);
    }

    /**
     * @expectedException \Jenerator\Exceptions\FormatFakerNotDefinedException
     */
    public function testInvalidLocation()
    {
        $container = Mockery::mock(ServiceContainerInterface::class)
            ->shouldReceive('make')
            ->andThrow(new \Exception())
            ->getMock();

        $accessor = Mockery::mock(JsonSchemaAccessorInterface::class);

        $instance = new FormatFakerFactory($container);
        $instance->getFakeDataForFormat('something', $accessor);
    }

}