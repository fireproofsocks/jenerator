<?php

namespace JeneratorTest\Generators\Object;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\Generators\Object\ObjectGeneratorFinal;
use Jenerator\Generators\Object\ObjectRequiredPropertiesGenerator;
use Jenerator\UseCases\GetExampleJsonFromSchema;
use JeneratorTest\TestCase;
use Mockery;

class ObjectRequiredPropertiesTest extends TestCase
{
    protected $valueGenerator;

    protected function getInstance()
    {
        $next = new ObjectGeneratorFinal();
        $this->valueGenerator = ($this->valueGenerator) ?: Mockery::mock(GetExampleJsonFromSchema::class);
        return new ObjectRequiredPropertiesGenerator($next, $this->valueGenerator);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }
}