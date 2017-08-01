<?php

namespace JeneratorTest\RandomString;

use Faker\Provider\Lorem;
use Jenerator\RandomString\RandomString;
use Jenerator\RandomString\RandomStringInterface;
use JeneratorTest\TestCase;
use Mockery;

class RandomStringTest extends TestCase
{
    protected function getInstance()
    {
        $mock = Mockery::mock(Lorem::class)
            ->shouldReceive('text')
            ->andReturn(md5(time()))
            ->getMock();
        return new RandomString($mock);
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(RandomStringInterface::class, $this->getInstance());
    }

    public function testGetRandomStringWithNoInputs()
    {
        $instance = $this->getInstance();
        $actual = $instance->getRandomString();
        $this->assertNotEmpty($actual);
    }

    public function testGetRandomStringWithMinimum()
    {
        $instance = $this->getInstance();
        $actual = $instance->getRandomString(3);
        $this->assertTrue(strlen($actual) >= 3);
    }

    public function testGetRandomStringWithMaximum()
    {
        $instance = $this->getInstance();
        $actual = $instance->getRandomString(3, 3);
        $this->assertEquals(3, strlen($actual));
    }
}