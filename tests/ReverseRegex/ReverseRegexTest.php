<?php

namespace JeneratorTest\ReverseRegex;

use Jenerator\ReverseRegex\ReverseRegexImproved;
use Jenerator\ReverseRegex\ReverseRegexInterface;
use JeneratorTest\TestCase;
use Mockery;
use RegRev\RegRev;

class ReverseRegexTest extends TestCase
{
    protected function getInstance()
    {
        $regRev = Mockery::mock(RegRev::class)
            ->shouldReceive('generate')
            ->andReturn('something')
            ->getMock();
        return new ReverseRegexImproved($regRev);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(ReverseRegexInterface::class, $this->getInstance());
    }

    public function testGetValueFromRegex()
    {
        $instance = $this->getInstance();
        $this->assertEquals('something', $instance->getValueFromRegex('some-regex'));
    }
}