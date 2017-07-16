<?php

namespace Jenerator\Generators;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class EnumGenerator implements GeneratorInterface
{
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor)
    {
        $enum = $schemaAccessor->getEnum();

        if ($enum === false) {
            throw new \Exception('No options found for "enum"');
        }

        if (!is_array($enum)) {
            throw new \InvalidArgumentException('"enum" must contain an array.');
        }

        // Choose a random element out of the array
        return $enum[array_rand($enum)];
    }

}