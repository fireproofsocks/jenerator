<?php

namespace Jenerator\ReferenceResolver;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorBuilderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class ReferenceResolver implements ReferenceResolverInterface
{
    /**
     * @var JsonSchemaAccessorBuilderInterface
     */
    protected $schemaAccessorBuilder;

    public function __construct(JsonSchemaAccessorBuilderInterface $schemaAccessorBuilder)
    {
        $this->schemaAccessorBuilder = $schemaAccessorBuilder;
    }
    /**
     * @inheritdoc
     */
    public function getSchema(array $schema, JsonSchemaAccessorInterface $schemaAccessor)
    {
        // TODO: Implement getSchema() method.
        $accessor = $this->schemaAccessorBuilder->getJsonSchemaAccessor($schema);


        if (!$ref = $accessor->getRef()) {
            return $schema;
        }

        // 1. local definition
        if ('#' === substr($ref, 0, 1)) {
            $schema = $this->getInlineSchema($ref);
            return $this->resolveSchema($schema);
        }
        // 3. "Remote" JSON file (anything with a protocol scheme)
        elseif (parse_url($ref, PHP_URL_SCHEME)) {
            $schema = $this->getRemoteSchema($ref);
            return $this->resolveSchema($schema);
        }
        // 4. Absolute local path
        elseif ('/' === substr($ref, 0, 1)) {
            $fullpath = $this->getFullPath($ref);
            $schema = $this->getRemoteSchema($fullpath);
            $this->storeWorkingBaseDirectoryFromFullPath($fullpath);
            return $this->resolveSchema($schema, $this->workingBaseDir);
        }
    }


    protected function getInlineSchema($ref)
    {
        // local definition - shift off the first part of the slash
        $relpath = ltrim($ref, '#/');
        $definition = ltrim(strstr($relpath, '/'), '/');
        return $this->schemaAccessor->getDefinition($definition);
    }

}