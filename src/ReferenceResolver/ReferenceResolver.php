<?php

namespace Jenerator\ReferenceResolver;

use Jenerator\JsonDecoder\JsonDecoderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ServiceContainerInterface;

class ReferenceResolver implements ReferenceResolverInterface
{
    /**
     * @var JsonSchemaAccessorFactoryInterface
     */
    protected $schemaAccessorFactory;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * @var ServiceContainerInterface
     */
    protected $serviceContainer;

    /**
     * to avoid duplicate remote lookups
     * @var array
     */
    protected $decodedCache = [];

    /**
     * @inheritdoc
     */
    public function resolveSchema($ref, JsonSchemaAccessorInterface $schemaAccessor, JsonSchemaAccessorFactoryInterface $schemaAccessorFactory)
    {
        $this->schemaAccessor = $schemaAccessor;

        // 1. local definition
        if ('#' === substr($ref, 0, 1)) {
            $schema = $this->getInlineSchema($ref);
            return $schemaAccessorFactory->getJsonSchemaAccessor($schema);
        }
        // 2. "Remote" JSON file (anything with a protocol scheme)
        elseif (parse_url($ref, PHP_URL_SCHEME)) {
            $schema = $this->getRemoteSchema($ref);
            return $schemaAccessorFactory->getJsonSchemaAccessor($schema);
        }
        // 3. Absolute local path
        elseif ('/' === substr($ref, 0, 1)) {
            $schema = $this->getRemoteSchema($ref);
            return $schemaAccessorFactory->getJsonSchemaAccessor($schema);
        }
    }

    /**
     * @param $ref string
     * @return mixed
     */
    protected function getInlineSchema($ref)
    {
        // local definition - shift off the first part of the slash
        $relpath = ltrim($ref, '#/');
        $definition = ltrim(strstr($relpath, '/'), '/');
        return $this->schemaAccessor->getDefinition($definition);
    }

    /**
     * @param $ref string
     * @return mixed
     */
    protected function getRemoteSchema($ref)
    {
        if (!isset($this->decodedCache[$ref])) {
            $this->decodedCache[$ref] = $this->serviceContainer->make(JsonDecoderInterface::class)->decodeFile($ref);
        }

        return $this->decodedCache[$ref];
    }

}