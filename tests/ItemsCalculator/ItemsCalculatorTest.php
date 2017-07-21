<?php

namespace JeneratorTest\ItemsCalculator;

use Jenerator\ItemsCalculator\ItemsCalculator;
use Jenerator\ItemsCalculator\ItemsCalculatorInterface;
use JeneratorTest\TestCase;

class ItemsCalculatorTest extends TestCase
{
    protected function getInstance()
    {
        return new ItemsCalculator();
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(ItemsCalculatorInterface::class, $this->getInstance());
    }

    public function testGetCountReturnsOneWhenOneMoreItemsIsRequired()
    {
        $instance = $this->getInstance();

        $actual = $instance->getCount(3, 4, 4);

        $this->assertEquals(1, $actual);
    }

    public function testGetCountIsBetween0and10()
    {
        $instance = $this->getInstance();

        $actual = $instance->getCount();

        $this->assertTrue($actual <= 10);
        $this->assertTrue($actual >= 0);
    }
}