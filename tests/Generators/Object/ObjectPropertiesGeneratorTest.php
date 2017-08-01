<?php

namespace JeneratorTest\Generators\Object;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\Generators\Object\ObjectGeneratorFinal;
use Jenerator\Generators\Object\ObjectPropertiesGenerator;
use Jenerator\Generators\ValueFromSchemaInterface;
use JeneratorTest\TestCase;
use Mockery;

class ObjectPropertiesGeneratorTest extends TestCase
{
    protected $next;

    protected $valueGenerator;

    protected function getInstance()
    {
        $this->next = new ObjectGeneratorFinal();
        $this->valueGenerator = Mockery::mock(ValueFromSchemaInterface::class);

        return new ObjectPropertiesGenerator($this->next, $this->valueGenerator);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }

    public function testGetGeneratedFakeValue()
    {
        $instance = $this->getInstance();
        $this->valueGenerator
            ->shouldReceive('getExampleValueFromSchema')
            ->andReturn('xray')
            ->getMock();

        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor(['properties' => ['x' => []], 'required' => ['x']]));

        $this->assertEquals((object) ['x' => 'xray'], $actual);

    }
}