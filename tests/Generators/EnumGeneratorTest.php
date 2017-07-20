<?php

namespace JeneratorTest\Generators;

use Jenerator\Generators\EnumGenerator;
use Jenerator\Generators\GeneratorInterface;
use JeneratorTest\TestCase;

class EnumGeneratorTest extends TestCase
{
    protected function getInstance()
    {
        return new EnumGenerator();
    }
    
    public function testInstantation()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->getInstance());
    }

    /**
     * @expectedException \Jenerator\Exceptions\InvalidSchemaException
     */
    public function testEmptyEnumThrowsException()
    {
        $instance = $this->getInstance();
        $instance->getGeneratedFakeValue($this->getSchemaAccessor());
    }

    /**
     * @expectedException \Jenerator\Exceptions\InvalidSchemaException
     */
    public function testEnumWithNonArrayThrowsException()
    {
        $instance = $this->getInstance();
        $instance->getGeneratedFakeValue($this->getSchemaAccessor(['enum' => 'not array']));
    }

    public function testRegularOperation()
    {
        $instance = $this->getInstance();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor(['enum' => ['only-one-answer']]));

        $this->assertEquals('only-one-answer', $actual);
    }

    public function testRegularOperationWithMultipleValues()
    {
        $enum = ['a','b','c'];
        $instance = $this->getInstance();
        $actual = $instance->getGeneratedFakeValue($this->getSchemaAccessor(['enum' => $enum]));

        $this->assertTrue(in_array($actual, $enum));
    }
}