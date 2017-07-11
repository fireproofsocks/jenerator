<?php

namespace Jenerator\JsonSchemaAccessor;

use Jenerator\Exceptions\SchemaAccessorException;
use Jenerator\ServiceContainerInterface;

class JsonSchemaAccessorBuilder implements JsonSchemaAccessorBuilderInterface
{
    /**
     * @var ServiceContainerInterface
     */
    protected $serviceContainer;

    /**
     * If no '$schema' property is declared, this is the version of the JSON Schema spec that we
     * assume we are working with.
     * @var string
     */
    protected $default_schema_version = 'http://json-schema.org/draft-04/schema#';

    /**
     * JsonSchemaAccessorBuilder constructor.
     * @param ServiceContainerInterface $serviceContainer
     */
    public function __construct(ServiceContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @inheritdoc
     */
    public function getJsonSchemaAccessor(array $schema)
    {
        $schema_version = (isset($schema['$schema'])) ? $schema['$schema'] : $this->default_schema_version;

        try {
            $schemaAccessor = $this->serviceContainer->make('accessor_'.$schema_version);
        }
        catch (\Exception $e) {
            throw new SchemaAccessorException('Accessor not defined for $schema '. $schema_version, $e->getCode(), $e);
        }

        return $schemaAccessor->hydrate($schema);
    }

}