<?php

namespace JeneratorTest\Generators\Object;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\Generators\Object\ObjectGeneratorFinal;
use Jenerator\Generators\Object\ObjectPatternPropertiesGenerator;
use Jenerator\Generators\ValueFromSchemaInterface;
use Jenerator\ReverseRegex\ReverseRegexInterface;
use JeneratorTest\TestCase;
use Mockery;

class ObjectPatternPropertiesTest extends TestCase
{
    protected $valueGenerator;
    protected $reverseRegex;

    protected function getInstance()
    {
        $next = new ObjectGeneratorFinal();
        $this->valueGenerator = Mockery::mock(ValueFromSchemaInterface::class);
        $this->reverseRegex = Mockery::mock(ReverseRegexInterface::class);

        return new ObjectPatternPropertiesGenerator($next, $this->valueGenerator, $this->reverseRegex);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }

    public function testGeneratingPropertyNamesAndValues()
    {
        $instance = $this->getInstance();

        $this->valueGenerator
            ->shouldReceive('getExampleValueFromSchema')
            ->andReturn('yes yes')
            ->getMock();
        $this->reverseRegex
            ->shouldReceive('getValueFromRegex')
            ->andReturn('xray')
            ->getMock();

        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor(['patternProperties' => [
            '^x_.*' => ['description' => 'some schema here']
        ]]));

        $this->assertTrue(property_exists($actual, 'xray'));
        $this->assertEquals($actual->xray, 'yes yes');
    }
}