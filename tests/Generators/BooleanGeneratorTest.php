<?php

namespace JeneratorTest\Generators;

use Jenerator\Generators\BooleanGenerator;
use Jenerator\Generators\GeneratorInterface;
use JeneratorTest\TestCase;

class BooleanGeneratorTest extends TestCase
{
    protected function getInstance()
    {
        return new BooleanGenerator();
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }

    public function testIsBooleanValue()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor());
        $this->assertTrue(is_bool($actual));
    }
}