<?php

namespace Jenerator\Generators;

use Faker\Provider\Base;
use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class NumberGenerator extends IntegerGenerator implements GeneratorInterface
{
    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor)
    {
        $this->schemaAccessor = $schemaAccessor;

        $minimum = $this->getMinimum();
        $maximum = $this->getMaximum();

        $number = Base::randomFloat(null, $minimum, $maximum);

        if ($multipleOf = $this->schemaAccessor->getMultipleOf()) {
            $number = $this->roundToNearestMultiple($number, $multipleOf);
        }

        return floatval($number);
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


}