<?php

namespace Jenerator\Generators;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

/**
 * Interface GeneratorInterface
 * @package Jenerator\Generators
 */
interface GeneratorInterface
{
    /**
     * Generate and return a fake value that matches the format/type/etc defined in the schema
     * @param JsonSchemaAccessorInterface $schemaAccessor
     * @return mixed
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor);
}