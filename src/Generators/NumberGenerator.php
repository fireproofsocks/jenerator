<?php

namespace Jenerator\Generators;

use Faker\Provider\Base;

class NumberGenerator implements GeneratorInterface
{
    /**
     * @inheritdoc
     */
    public function getValue(array $schema)
    {
        // TODO: Implement getValue() method.
        // $nbMaxDecimals = null, $min = 0, $max = null
        return Base::randomFloat();
    }

}