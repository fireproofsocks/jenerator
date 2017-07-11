<?php

namespace Jenerator\Generators;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class ArrayGenerator implements GeneratorInterface
{

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * @var GeneratorBuilderInterface
     */
    protected $generatorBuilder;

    public function __construct(JsonSchemaAccessorInterface $schemaAccessor, GeneratorBuilderInterface $generatorBuilder)
    {
        $this->schemaAccessor = $schemaAccessor;
        $this->generatorBuilder = $generatorBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor)
    {
        // TODO: Implement getValue() method.
        $output = [];

        $this->schemaAccessor->factory($schema);

        if ($items = $schemaAccessor->getItems()) {
            // Is tuple?
        }

        // minItems
        // maxItems
        for ($i = 0; $i < 3; $i++ ) {

            $output[] = $this->generatorBuilder->getGenerator('string')->getGeneratedFakeValue([]);
        }
        // additionalItems

        return $output;
    }

}