<?php

namespace JeneratorTest\Generators\Object;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\Generators\Object\ObjectGeneratorFinal;
use Jenerator\Generators\Object\ObjectRequiredPropertiesGenerator;
use Jenerator\Generators\ValueFromSchema;
use JeneratorTest\TestCase;
use Mockery;

class ObjectRequiredPropertiesTest extends TestCase
{
    protected $valueGenerator;

    protected function getInstance()
    {
        $next = new ObjectGeneratorFinal();
        $this->valueGenerator = Mockery::mock(ValueFromSchema::class);
        return new ObjectRequiredPropertiesGenerator($next, $this->valueGenerator);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }

    public function testPatternProperties()
    {
        $instance = $this->getInstance();
        $this->valueGenerator
            ->shouldReceive('getExampleValueFromSchema')
            ->andReturn('unrandom-string')
            ->getMock();

        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'required' => ['str_x', 'str_y'],
            'patternProperties' => [
                '^str_.*' => [
                    'type' => 'string'
                ]
            ]
        ]));

        $this->assertEquals(2, count((array) $actual));
    }

    public function testAdditionalProperties()
    {
        $instance = $this->getInstance();
        $this->valueGenerator
            ->shouldReceive('getExampleValueFromSchema')
            ->andReturn('unrandom-string')
            ->getMock();

        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'required' => ['zzz'],
            'additionalProperties' => [
                'type' => 'string'
            ]
        ]));

        $this->assertEquals((object) ['zzz' => 'unrandom-string'], $actual);
    }
}