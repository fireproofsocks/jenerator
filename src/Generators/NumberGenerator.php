<?php

namespace Jenerator\Generators;

use Faker\Provider\Base;
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

        $decimals = $schemaAccessor->getKeyword('decimals', 2);

        $number = Base::randomFloat($decimals, $minimum, $maximum);

        if ($multipleOf = $this->schemaAccessor->getMultipleOf()) {
            $number = $this->roundToNearestMultiple($number, $multipleOf, $minimum, $maximum);
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
            $maximum = $maximum - 0.1;
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
            $minimum = $minimum + 0.1;
        }

        return $minimum;
    }


}