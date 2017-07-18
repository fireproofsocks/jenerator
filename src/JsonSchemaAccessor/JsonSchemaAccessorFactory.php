<?php

namespace Jenerator\JsonSchemaAccessor;

use Jenerator\Exceptions\SchemaAccessorException;
use Jenerator\JsonDecoder\JsonDecoderInterface;
use Jenerator\ReferenceResolver\ReferenceResolverInterface;
use Pimple\Container;

class JsonSchemaAccessorFactory implements JsonSchemaAccessorFactoryInterface
{
    /**
     * @var Container
     */
    protected $serviceContainer;

    /**
     * @var ReferenceResolverInterface
     */
    protected $referenceResolver;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * If no '$schema' property is declared, this is the version of the JSON Schema spec that we
     * assume we are working with.
     * @var string
     */
    protected $default_schema_version = 'http://json-schema.org/draft-04/schema#';

    /**
     * JsonSchemaAccessorFactory constructor.
     * @param Container $serviceContainer
     */
    public function __construct(Container $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
        $this->referenceResolver = $this->serviceContainer->make(ReferenceResolverInterface::class);
    }

    /**
     * @inheritdoc
     */
    public function getJsonSchemaAccessor(array $schema)
    {
        $schema_version = (isset($schema['$schema'])) ? $schema['$schema'] : $this->default_schema_version;

        try {
            $this->schemaAccessor = $this->serviceContainer->offsetGet('accessor_'.$schema_version);
        }
        catch (\Exception $e) {
            throw new SchemaAccessorException('Accessor not defined for $schema '. $schema_version, $e->getCode(), $e);
        }

        $this->schemaAccessor->hydrate($schema);

        if ($ref = $this->schemaAccessor->getRef()) {
            $this->schemaAccessor = $this->referenceResolver->resolveSchema($ref, $this->schemaAccessor, $this);
        }

        if ($anyOf = $this->schemaAccessor->getAnyOf()) {
            if (!is_array($anyOf)) {
                throw new SchemaAccessorException('"anyOf" must define an array of schemas.');
            }
            return $this->getJsonSchemaAccessor($anyOf[array_rand($anyOf)]);
        }

        if ($oneOf = $this->schemaAccessor->getOneOf()) {
            if (!is_array($oneOf)) {
                throw new SchemaAccessorException('"oneOf" must define an array of schemas.');
            }
            return $this->getJsonSchemaAccessor($oneOf[array_rand($oneOf)]);
        }

        return $this->schemaAccessor;
    }

}