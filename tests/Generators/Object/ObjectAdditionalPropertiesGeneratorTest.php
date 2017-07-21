<?php

namespace JeneratorTest\Generators\Object;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\Generators\Object\ObjectAdditionalPropertiesGenerator;
use Jenerator\Generators\Object\ObjectGeneratorFinal;
use Jenerator\ItemsCalculator\ItemsCalculatorInterface;
use Jenerator\UseCases\GetExampleJsonFromSchemaInterface;
use JeneratorTest\TestCase;
use Mockery;

class ObjectAdditionalPropertiesGeneratorTest extends TestCase
{
    protected $valueGenerator;
    protected $itemsCalculator;

    protected function getInstance()
    {
        $this->valueGenerator = Mockery::mock(GetExampleJsonFromSchemaInterface::class);
        $this->itemsCalculator = Mockery::mock(ItemsCalculatorInterface::class);
        $next = new ObjectGeneratorFinal();

        return new ObjectAdditionalPropertiesGenerator($next, $this->valueGenerator, $this->itemsCalculator);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }
    
    public function testNoActionTakenForSchemaWithoutAdditionalProperties()
    {
        $instance = $this->getInstance();

        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'additionalProperties' => false
        ]));

        $this->assertEquals(new \stdClass(), $actual);
    }
    
    public function testThatASpecificNumberOfPropertiesIsGenerated()
    {
        $instance = $this->getInstance();
        $this->valueGenerator
            ->shouldReceive('getExampleValueFromSchema')
            ->andReturn('random')
            ->getMock();
        $this->itemsCalculator
            ->shouldReceive('getCount')
            ->andReturn(5)
            ->getMock();

        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'additionalProperties' => [
            ],
            'minProperties' => 5,
            'maxProperties' => 5
        ]));

        $this->assertEquals(5, count((array) $actual));

    }
}