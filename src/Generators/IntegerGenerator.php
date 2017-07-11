<?php

namespace Jenerator\Generators;

use Faker\Provider\Base;

class IntegerGenerator implements GeneratorInterface
{
    /**
     * @inheritdoc
     */
    public function getValue(array $schema)
    {
        // TODO: min, max, multipleOf etc
        // $int1 = 0, $int2 = 2147483647
        return Base::numberBetween();
    }

}