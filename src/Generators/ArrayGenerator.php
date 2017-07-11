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
    public function getValue(array $schema)
    {
        // TODO: Implement getValue() method.
        $output = [];

        $this->schemaAccessor->factory($schema);

        if ($items = $this->schemaAccessor->getItems()) {
            // Is tuple?
        }

        // minItems
        // maxItems
        for ($i = 0; $i < 3; $i++ ) {

            $output[] = $this->generatorBuilder->getGenerator('string')->getValue([]);
        }
        // additionalItems

        return $output;
    }

}