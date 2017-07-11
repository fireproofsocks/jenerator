<?php

namespace Jenerator\Generators;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorBuilderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class ObjectGenerator implements GeneratorInterface
{
    /**
     * @var JsonSchemaAccessorBuilderInterface
     */
    protected $schemaAccessorBuilder;

    /**
     * @var GeneratorBuilderInterface
     */
    protected $generatorBuilder;

    public function __construct(JsonSchemaAccessorBuilderInterface $schemaAccessorBuilder, GeneratorBuilderInterface $generatorBuilder)
    {
        $this->schemaAccessorBuilder = $schemaAccessorBuilder;
        $this->generatorBuilder = $generatorBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor)
    {
        $obj = new \stdClass();

        // TODO: patternProperties, minProperties, maxProperties, additionalProperties, dependencies, required

        if ($properties = $schemaAccessor->getProperties()) {
            foreach ($properties as $property_name => $sub_schema) {
                $subAccessor = $this->schemaAccessorBuilder->getJsonSchemaAccessor($sub_schema);
                $generator = $this->generatorBuilder->getGenerator($subAccessor);
                $obj->{$property_name} = $generator->getGeneratedFakeValue($subAccessor);
                //$obj->{$key} =
            }
        }
        // required
        // additionalProperties

        return $obj;
    }

}