<?php

namespace Jenerator\Generators;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorBuilderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaV4Accessor;

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
    public function getValue(array $schema)
    {
        $obj = new \stdClass();

        // TODO: Implement getValue() method.
        $accessor = $this->schemaAccessorBuilder->getJsonSchemaAccessor($schema);

        // TODO: patternProperties

        if ($properties = $accessor->getProperties()) {
            foreach ($properties as $property_name => $sub_schema) {
                $subAccessor = $this->schemaAccessorBuilder->getJsonSchemaAccessor($sub_schema);
                $generator = $this->generatorBuilder->getGenerator($sub_schema->getType());
                //$obj->{$key} =
            }
        }

        return $obj;
    }

}