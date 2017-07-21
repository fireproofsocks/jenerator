<?php

namespace JeneratorTest\Generators;

use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\Generators\GeneratorInterface;
use Jenerator\Generators\StringGenerator;
use Jenerator\RandomString\RandomStringInterface;
use Jenerator\ReverseRegex\ReverseRegexInterface;
use JeneratorTest\TestCase;
use Mockery;

class StringGeneratorTest extends TestCase
{
    protected $formatFaker;

    protected $reverseRegex;

    protected $randomString;

    protected function getInstance()
    {
        $this->formatFaker = ($this->formatFaker) ?: Mockery::mock(FormatFakerFactoryInterface::class);
        $this->reverseRegex = ($this->reverseRegex) ?: Mockery::mock(ReverseRegexInterface::class);
        $this->randomString = ($this->randomString) ?: Mockery::mock(RandomStringInterface::class);

        return new StringGenerator($this->formatFaker, $this->reverseRegex, $this->randomString);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }

    public function testValueFromFormat()
    {
        $this->formatFaker = Mockery::mock(FormatFakerFactoryInterface::class)
            ->shouldReceive('getFakeDataForFormat')
            ->andReturn('something')
            ->getMock();

        $instance = $this->getInstance();

        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor(['format' => 'anything']));

        $this->assertEquals('something', $actual);
    }
    
    public function testValueFromRegex()
    {
        $this->formatFaker = Mockery::mock(FormatFakerFactoryInterface::class);
        $this->reverseRegex = Mockery::mock(ReverseRegexInterface::class)
            ->shouldReceive('getValueFromRegex')
            ->andReturn('something')
            ->getMock();

        $instance = $this->getInstance();

        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor(['pattern' => '^something$']));

        $this->assertEquals('something', $actual);
    }

    public function testValueFromRandomString()
    {
        $this->formatFaker = Mockery::mock(FormatFakerFactoryInterface::class);
        $this->reverseRegex = Mockery::mock(ReverseRegexInterface::class);
        $this->randomString = Mockery::mock(RandomStringInterface::class)
            ->shouldReceive('getRandomString')
            ->andReturn('Lorem')
            ->getMock();

        $instance = $this->getInstance();

        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor([]));

        $this->assertEquals('Lorem', $actual);
    }
}