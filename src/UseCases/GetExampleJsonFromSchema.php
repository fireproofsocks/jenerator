<?php

namespace Jenerator\UseCases;

use Jenerator\Generators\GeneratorBuilderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorBuilderInterface;

class GetExampleJsonFromSchema implements GetExampleJsonFromSchemaInterface
{
    protected $jsonDecoder;
    protected $jsonEncoder;
    protected $schemaAccessorBuilder;
    protected $generatorBuilder;
    protected $transformersContainer;

    /**
     * GetExampleJsonFromSchema constructor.
     * @param JsonSchemaAccessorBuilderInterface $schemaAccessorBuilder
     * @param GeneratorBuilderInterface $generatorBuilder
     */
    public function __construct(JsonSchemaAccessorBuilderInterface $schemaAccessorBuilder, GeneratorBuilderInterface $generatorBuilder)
    {
        $this->schemaAccessorBuilder = $schemaAccessorBuilder;
        $this->generatorBuilder = $generatorBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getExampleJsonFromSchema(array $schema)
    {
        $accessor = $this->schemaAccessorBuilder->getJsonSchemaAccessor($schema);

        $generator = $this->generatorBuilder->getGenerator($accessor);

        return $generator->getGeneratedFakeValue($accessor);
    }
}