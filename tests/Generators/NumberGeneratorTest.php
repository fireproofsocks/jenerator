<?php

namespace JeneratorTest\Generators;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\Generators\NumberGenerator;
use JeneratorTest\TestCase;

class NumberGeneratorTest extends TestCase
{
    protected function getInstance()
    {
        return new NumberGenerator();
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }

    public function testExclusiveMinimum()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'minimum' => 1,
            'maximum' => 2,
            'exclusiveMinimum' => true
        ]));

        $this->assertTrue($actual < 2);
        $this->assertTrue($actual >= 1);
    }

    public function testMaximum()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'maximum' => -2147483647
        ]));

        $this->assertEquals(-2147483647, $actual);
    }

    public function testExclusiveMaximum()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'minimum' => 1,
            'maximum' => 2,
            'exclusiveMaximum' => true
        ]));

        $this->assertTrue($actual >= 1);
        $this->assertTrue($actual < 2);
    }

    public function testMultipleOf()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'minimum' => 5,
            'maximum' => 9,
            'multipleOf' => 5
        ]));

        $this->assertEquals(5, $actual);
    }
}