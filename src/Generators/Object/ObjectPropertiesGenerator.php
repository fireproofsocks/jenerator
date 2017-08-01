<?php

namespace Jenerator\Generators\Object;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ServiceContainerInterface;
use Jenerator\Generators\ValueFromSchemaInterface;

class ObjectPropertiesGenerator implements GeneratorInterface
{
    /**
     * @var GeneratorInterface
     */
    protected $next;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * @var ValueFromSchemaInterface
     */
    protected $valueGenerator;

    public function __construct(GeneratorInterface $next, ValueFromSchemaInterface $valueGenerator)
    {
        $this->next = $next;
        $this->valueGenerator = $valueGenerator;
    }
    /**
     * @inheritDoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor, $obj = null)
    {

        $this->schemaAccessor = $schemaAccessor;

        $obj = ($obj) ? $obj : new \stdClass();

        if ($properties = $this->schemaAccessor->getProperties()) {
            $obj = $this->generateProperties($properties, $obj);
        }

        return $this->next->getGeneratedFakeValue($schemaAccessor, $obj);
    }

    protected function generateProperties(array $properties, $obj)
    {
        foreach ($properties as $property_name => $sub_schema) {
            if ($this->includeProperty($property_name)) {
                $obj->{$property_name} = $this->valueGenerator->getExampleValueFromSchema($sub_schema);
            }
        }

        return $obj;
    }

    /**
     * Should the given property be included?
     * @param $property_name
     * @return bool
     */
    protected function includeProperty($property_name)
    {
        return (in_array($property_name, $this->schemaAccessor->getRequired()) || $this->coinFlip());
    }

    /**
     * @return bool
     */
    protected function coinFlip()
    {
        return (bool) rand(0,1);
    }
}