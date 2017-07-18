<?php

namespace Jenerator\ReferenceResolver;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

/**
 * Interface ReferenceResolverInterface
 *
 * Resolves any usage of the "$ref" keyword
 *
 * @package Jenerator\ReferenceResolver
 */
interface ReferenceResolverInterface
{
    /**
     * Resolve the reference defined by $ref.  This should return a new JsonSchemaAccessorInterface pointed at the
     * the targeted $ref.
     *
     * @param $ref string
     * @param JsonSchemaAccessorInterface $schemaAccessor
     * @param JsonSchemaAccessorFactoryInterface $schemaAccessorFactory
     * @return JsonSchemaAccessorInterface
     */
    public function resolveSchema($ref, JsonSchemaAccessorInterface $schemaAccessor, JsonSchemaAccessorFactoryInterface $schemaAccessorFactory);
}