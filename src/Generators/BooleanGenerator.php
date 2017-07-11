<?php

namespace Jenerator\Generators;

use Faker\Provider\Miscellaneous;

class BooleanGenerator implements GeneratorInterface
{
    /**
     * @inheritdoc
     */
    public function getValue(array $schema)
    {
        return Miscellaneous::boolean();
    }

}