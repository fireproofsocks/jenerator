<?php

namespace JeneratorTest\Generators;

use Jenerator\Generators\ArrayGenerator;
use Jenerator\Generators\GeneratorInterface;
use Jenerator\UseCases\GetExampleJsonFromSchemaInterface;
use JeneratorTest\TestCase;
use Mockery;

class ArrayGeneratorTest extends TestCase
{
    protected function getInstance(MockValueGenerator $valueGenerator)
    {
        return new ArrayGenerator($valueGenerator);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance(new MockValueGenerator()));
    }

    public function testMinItems()
    {
        $output = range(10, 100, 10);
        $instance = $this->getInstance(new MockValueGenerator($output));
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'minItems' => 3
        ]));

        $this->assertTrue(count($actual) >= 3);
    }

    public function testMaxItems()
    {
        $output = range(10, 100, 10);
        $instance = $this->getInstance(new MockValueGenerator($output));
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'maxItems' => 3
        ]));

        $this->assertTrue(count($actual) <= 3);
    }

    public function testSpecificArrayItemCountIsObeyed()
    {
        $output = range(10, 100, 10);
        $instance = $this->getInstance(new MockValueGenerator($output));
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
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([
            'minItems' => 3,
            'maxItems' => 3,
            'uniqueItems' => true
        ]));

        $this->assertEquals(array_unique($actual), $actual);
    }
    
    public function testTuple()
    {

    }
}

class MockValueGenerator implements GetExampleJsonFromSchemaInterface
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