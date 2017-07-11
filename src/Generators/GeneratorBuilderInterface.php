<?php

namespace Jenerator\Generators;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

/**
 * Interface GeneratorBuilderInterface
 *
 * Applies logic to determine which Generator class is returned.
 *
 * @package Jenerator\Generators
 */
interface GeneratorBuilderInterface
{
    /**
     * Given a loaded JSON Schema Accessor, this returns a generator that can generate sample data for the given schema.
     * @param JsonSchemaAccessorInterface $jsonSchemaAccessor
     * @return GeneratorInterface
     */
    public function getGenerator(JsonSchemaAccessorInterface $jsonSchemaAccessor);
}