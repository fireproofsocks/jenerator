<?php

namespace Jenerator\Generators\Object;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class ObjectGeneratorFinal implements GeneratorInterface
{
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor, $obj = null)
    {
        return $obj;
    }
}