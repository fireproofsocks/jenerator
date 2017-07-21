<?php

namespace JeneratorTest\Generators;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\Generators\NullGenerator;
use JeneratorTest\TestCase;

class NullGeneratorTest extends TestCase
{
    protected function getInstance()
    {
        return new NullGenerator();
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }

    public function testIsNull()
    {
        $this->assertNull($this->getInstance()->getGeneratedFakeValue($this->getSchemaAccessor()));
    }
}