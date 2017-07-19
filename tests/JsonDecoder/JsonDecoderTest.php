<?php

namespace JeneratorTest\JsonDecoder;

use Jenerator\Exceptions\JsonDecodingException;
use Jenerator\JsonDecoder\JsonDecoderInterface;
use JeneratorTest\TestCase;

class JsonDecoderTest extends TestCase
{
    protected function getInstance()
    {
        return $this->container->make(JsonDecoderInterface::class);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(JsonDecoderInterface::class, $this->getInstance());
    }

    public function testDecodeStringReturnsValid()
    {
        $instance = $this->getInstance();
        $result = $instance->decodeString('{"foo":"bar"}');
        $this->assertEquals(['foo' => 'bar'], $result);
    }

    /**
     * @expectedException \Jenerator\Exceptions\JsonDecodingException
     */
    public function testDecodeStringThrowsExceptionOnInvalidInput()
    {
        $instance = $this->getInstance();
        $instance->decodeString('{"foo":"bar"');
    }

    public function testDecodeFileReturnsValid()
    {
        $instance = $this->getInstance();
        $result = $instance->decodeFile(__DIR__.'/../schemas/primitives/integer.json');
        $this->assertEquals(['type' => 'integer'], $result);
    }

    /**
     * @expectedException \Jenerator\Exceptions\JsonDecodingException
     */
    public function testDecodeFileThrowsExceptionWhenNoFileExists()
    {
        $instance = $this->getInstance();
        $instance->decodeFile(__DIR__.'/file-does-not-exist.json');
    }
}