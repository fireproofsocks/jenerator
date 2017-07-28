<?php

namespace JeneratorTest\Generators;

use Jenerator\Generators\ArrayGenerator;
use Jenerator\Generators\GeneratorInterface;
use Jenerator\ItemsCalculator\ItemsCalculatorInterface;
use Jenerator\Generators\ValueFromSchemaInterface;
use JeneratorTest\TestCase;
use Mockery;

class ArrayGeneratorTest extends TestCase
{
    protected $itemsCalculator;

    protected function getInstance(MockValueGenerator $valueGenerator)
    {
        $this->itemsCalculator = Mockery::mock(ItemsCalculatorInterface::class);

        return new ArrayGenerator($valueGenerator, $this->itemsCalculator);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance(new MockValueGenerator()));
    }

    public function testMinItems()
    {
        $output = range(10, 100, 10);
        $instance = $this->getInstance(new MockValueGenerator($output));
        $this->itemsCalculator
            ->shouldReceive('getCount')
            ->andReturn(5)
            ->getMock();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'minItems' => 3
        ]));

        $this->assertEquals(5,count($actual));
    }

    public function testMaxItems()
    {
        $output = range(10, 100, 10);
        $instance = $this->getInstance(new MockValueGenerator($output));
        $this->itemsCalculator
            ->shouldReceive('getCount')
            ->andReturn(3)
            ->getMock();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'maxItems' => 3
        ]));

        $this->assertEquals(3,count($actual));
    }

    public function testSpecificArrayItemCountIsObeyed()
    {
        $output = range(10, 100, 10);
        $instance = $this->getInstance(new MockValueGenerator($output));
        $this->itemsCalculator
            ->shouldReceive('getCount')
            ->andReturn(3)
            ->getMock();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'minItems' => 3,
            'maxItems' => 3
        ]));

        $this->assertEquals(3, count($actual));
    }

    public function testUniqueItems()
    {
        $output = ['a', 'a', 'b', 'c'];
        $instance = $this->getInstance(new MockValueGenerator($output));
        $this->itemsCalculator
            ->shouldReceive('getCount')
            ->andReturn(3)
            ->getMock();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'minItems' => 3,
            'maxItems' => 3,
            'uniqueItems' => true
        ]));

        $this->assertEquals(array_unique($actual), $actual);
    }
    
    public function testTuple()
    {
        $output = [false, 1, 'my string'];
        $instance = $this->getInstance(new MockValueGenerator($output));
        $this->itemsCalculator
            ->shouldReceive('getCount')
            ->andReturn(3)
            ->getMock();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'items' => [
                ['type' => 'boolean'],
                ['type' => 'integer'],
                ['type' => 'string'],
            ]
        ]));

        $this->assertEquals($output, $actual);
    }

    public function testTupleWithAdditionalItems()
    {
        $output = [false, 1, 'my string', true, true];

        $instance = $this->getInstance(new MockValueGenerator($output));
        $this->itemsCalculator
            ->shouldReceive('getCount')
            ->andReturn(5) // 2 additional items
            ->getMock();

        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'items' => [
                ['type' => 'boolean'],
                ['type' => 'integer'],
                ['type' => 'string'],
            ],
            'additionalItems' => [
                'type' => 'boolean'
            ],
            'minItems' => 5,
            'maxItems' => 5
        ]));


        $this->assertEquals($output, $actual);
    }
}

class MockValueGenerator implements ValueFromSchemaInterface
{
    protected $i = 0;
    protected $output = [];

    public function __construct(array $output = [])
    {
        $this->output = $output;
    }

    /**
     * @inheritDoc
     */
    public function getExampleValueFromSchema(array $schema)
    {
        $out = $this->output[$this->i];
        $this->i++;
        return $out;
    }

}