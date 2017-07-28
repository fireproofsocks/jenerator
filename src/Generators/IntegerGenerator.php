<?php

namespace Jenerator\Generators;

use Faker\Provider\Base;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class IntegerGenerator implements GeneratorInterface
{
    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor)
    {
        $this->schemaAccessor = $schemaAccessor;

        $minimum = $this->getMinimum();
        $maximum = $this->getMaximum();

        $number = Base::numberBetween($minimum, $maximum);

        if ($multipleOf = $this->schemaAccessor->getMultipleOf()) {
            $number = $this->roundToNearestMultiple($number, $multipleOf, $minimum, $maximum);
        }

        return (int) $number;
    }

    /**
     * @return int
     */
    protected function getMaximum()
    {
        $maximum = $this->schemaAccessor->getMaximum();

        $maximum = ($maximum === false) ? 2147483647 : $maximum;

        if ($this->schemaAccessor->getExclusiveMaximum()) {
            $maximum = $maximum - 1;
        }

        return $maximum;
    }

    /**
     * @return int
     */
    protected function getMinimum()
    {
        $minimum = $this->schemaAccessor->getMinimum();

        $minimum = ($minimum === false) ? -2147483647 : $minimum;

        if ($this->schemaAccessor->getExclusiveMinimum()) {
            $minimum = $minimum + 1;
        }

        return $minimum;
    }

    /**
     * Some futzing to correct for rounding that may land the number outside the range.
     *
     * @param $number number
     * @param $multipleOf number
     * @param $minimum
     * @param $maximum
     * @return float
     */
    protected function roundToNearestMultiple($number, $multipleOf, $minimum, $maximum)
    {
        $rounded = round($number/$multipleOf) * $multipleOf;
        $rounded = ($rounded > $maximum) ? $rounded - $multipleOf : $rounded;
        $rounded = ($rounded < $minimum) ? $rounded + $multipleOf : $rounded;

        return $rounded;
    }

}