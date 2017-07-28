<?php

namespace Jenerator\Generators;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;

class ValueFromSchema implements ValueFromSchemaInterface
{
    protected $jsonDecoder;
    protected $jsonEncoder;
    protected $schemaAccessorBuilder;
    protected $generatorBuilder;
    protected $transformersContainer;

    /**
     * ValueFromSchema constructor.
     * @param JsonSchemaAccessorFactoryInterface $schemaAccessorBuilder
     * @param GeneratorFactoryInterface $generatorBuilder
     */
    public function __construct(JsonSchemaAccessorFactoryInterface $schemaAccessorBuilder, GeneratorFactoryInterface $generatorBuilder)
    {
        $this->schemaAccessorBuilder = $schemaAccessorBuilder;
        $this->generatorBuilder = $generatorBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getExampleValueFromSchema(array $schema)
    {
        $accessor = $this->schemaAccessorBuilder->getJsonSchemaAccessor($schema);

        $generator = $this->generatorBuilder->getGenerator($accessor);

        return $generator->getGeneratedFakeValue($accessor);
    }
}