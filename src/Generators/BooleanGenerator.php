<?php

namespace Jenerator\Generators;

use Faker\Provider\Miscellaneous;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class BooleanGenerator implements GeneratorInterface
{
    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor)
    {
        return Miscellaneous::boolean();
    }

}