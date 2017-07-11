<?php

namespace Jenerator\JsonSchemaAccessor;

/**
 * Interface JsonSchemaAccessorBuilderInterface
 *
 * This will determine which schema accessor instance to return for the given schema.
 * E.g. this would distinguish between a JSON Schema v4 or v5 accessor class, or it could support custom schemas.
 * TODO: custom schemas should not need to follow the same interface as the JSON Schema ones
 *
 * @see http://json-schema.org/latest/json-schema-core.html#rfc.section.6.4
 * @package Jenerator\JsonSchemaAccessor
 */
interface JsonSchemaAccessorBuilderInterface
{
    /**
     * Return the appropriate accessor class
     * @param array $schema
     * @return JsonSchemaAccessorInterface
     */
    public function getJsonSchemaAccessor(array $schema);
}