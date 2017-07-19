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
        $schema_version = $this->getSchemaVersion($schema);

        try {
            $this->schemaAccessor = $this->serviceContainer->offsetGet('accessor_' . $schema_version);
        } catch (\Exception $e) {
            throw new SchemaAccessorException('Accessor not defined for $schema ' . $schema_version, $e->getCode(), $e);
        }

        $this->schemaAccessor->hydrate($schema);

        $this->resolveRef();

        if ($anyOf = $this->schemaAccessor->getAnyOf()) {
            if (!is_array($anyOf)) {
                throw new SchemaAccessorException('"anyOf" must define an array of schemas.');
            }
            return $this->getJsonSchemaAccessor($anyOf[array_rand($anyOf)]);
        }

        if ($oneOf = $this->schemaAccessor->getOneOf()) {
            // TODO: this can be inaccurate - to be valid, the value must validate against ONLY ONE of the schemas
            if (!is_array($oneOf)) {
                throw new SchemaAccessorException('"oneOf" must define an array of schemas.');
            }
            return $this->getJsonSchemaAccessor($oneOf[array_rand($oneOf)]);
        }

        $this->resolveAllOf();

        return $this->schemaAccessor;
    }

    /**
     * @param array $schema
     * @return string
     */
    protected function getSchemaVersion(array $schema)
    {
        return (isset($schema['$schema'])) ? $schema['$schema'] : $this->default_schema_version;
    }

    /**
     * Resolve any $ref parameters that point to other schemas
     */
    protected function resolveRef()
    {
        if ($ref = $this->schemaAccessor->getRef()) {
            $this->schemaAccessor = $this->referenceResolver->resolveSchema($ref, $this->schemaAccessor, $this);
        }
    }

    /**
     * If the schema uses the "allOf" keyword, this handles merging the schemas into one coherent schema.
     * WARNING: the merging can be faulty.  E.g if 1 schema defines minimum 10, and another defines minimum 20.  The
     * last value ends up in the merge, so the merged schema will use minimum 20, which is not fully valid.
     * TODO: improved allOf merging.
     *
     * @throws SchemaAccessorException
     */
    protected function resolveAllOf()
    {
        if ($allOf = $this->schemaAccessor->getAllOf()) {
            if (!is_array($allOf)) {
                throw new SchemaAccessorException('"allOf" must define an array of schemas.');
            }

            $merged = [];
            foreach ($allOf as $subSchema) {
                $merged = array_merge_recursive($merged, $this->getJsonSchemaAccessor($subSchema)->toArray());
            }
            $this->schemaAccessor->hydrate($merged);
        }
    }
}