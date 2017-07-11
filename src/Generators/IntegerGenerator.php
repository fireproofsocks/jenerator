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

        return (int) $this->roundToNearestMultiple($number);
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
     * @param $number
     * @return float
     */
    protected function roundToNearestMultiple($number)
    {
        if ($multipleOf = $this->schemaAccessor->getMultipleOf()) {
            $number = round($multipleOf/$multipleOf) * $multipleOf;
        }

        return $number;
    }

}