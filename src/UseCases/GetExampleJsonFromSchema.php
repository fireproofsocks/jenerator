<?php

namespace Jenerator\UseCases;

use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;

class GetExampleJsonFromSchema implements GetExampleJsonFromSchemaInterface
{
    protected $jsonDecoder;
    protected $jsonEncoder;
    protected $schemaAccessorBuilder;
    protected $generatorBuilder;
    protected $transformersContainer;

    /**
     * GetExampleJsonFromSchema constructor.
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