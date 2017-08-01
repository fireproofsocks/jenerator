<?php

namespace Jenerator\Generators;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;

class ValueFromSchema implements ValueFromSchemaInterface
{
    protected $jsonDecoder;
    protected $jsonEncoder;
    protected $schemaAccessorBuilder;
    protected $generatorFactory;
    protected $transformersContainer;

    /**
     * ValueFromSchema constructor.
     * @param JsonSchemaAccessorFactoryInterface $schemaAccessorBuilder
     * @param GeneratorFactoryInterface $generatorFactory
     */
    public function __construct(JsonSchemaAccessorFactoryInterface $schemaAccessorBuilder, GeneratorFactoryInterface $generatorFactory)
    {
        $this->schemaAccessorBuilder = $schemaAccessorBuilder;
        $this->generatorFactory = $generatorFactory;
    }

    /**
     * @inheritdoc
     */
    public function getExampleValueFromSchema(array $schema)
    {
        $accessor = $this->schemaAccessorBuilder->getJsonSchemaAccessor($schema);

        $generator = $this->generatorFactory->getGenerator($accessor);

        return $generator->getGeneratedFakeValue($accessor);
    }
}