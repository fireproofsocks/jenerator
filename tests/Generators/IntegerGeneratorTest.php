<?php

namespace JeneratorTest\Generators;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\Generators\IntegerGenerator;
use JeneratorTest\TestCase;

class IntegerGeneratorTest extends TestCase
{
    protected function getInstance()
    {
        return new IntegerGenerator();
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }

    public function testMinimum()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'minimum' => 2147483647
        ]));

        $this->assertEquals(2147483647, $actual);
    }

    public function testExclusiveMinimum()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'minimum' => 1,
            'maximum' => 2,
            'exclusiveMinimum' => true
        ]));

        $this->assertEquals(2, $actual);
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

        $this->assertEquals(1, $actual);
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