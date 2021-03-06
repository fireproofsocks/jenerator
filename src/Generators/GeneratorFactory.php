<?php

namespace Jenerator\Generators;

use Jenerator\Exceptions\InvalidTypeException;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ServiceContainerInterface;

class GeneratorFactory implements GeneratorFactoryInterface
{
    /**
     * @var ServiceContainerInterface
     */
    protected $serviceContainer;

    /**
     * Valid data types (per JSON Schema) -- TODO: put into the accessor class?
     * @var array
     */
    protected $validTypes = ['object', 'array', 'string', 'number', 'integer', 'boolean', 'null'];

    public function __construct(ServiceContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @inheritdoc
     */
    public function getGenerator(JsonSchemaAccessorInterface $jsonSchemaAccessor)
    {
        if ($enum = $jsonSchemaAccessor->getEnum()) {
            $type = 'enum';
        } else {
            $type = $jsonSchemaAccessor->getType();

            if (!$type) {
                $type = $this->getRandomType();
            } elseif (is_array($type)) {
                $type = $this->getRandomType($type);
            }
        }

        try {
            $generator = $this->serviceContainer->make('generator_' . $type);
        } catch (\Exception $e) {
            throw new InvalidTypeException('The type "' . $type . '" is not a valid JSON Schema type', $e->getCode(),
                $e);
        }

        return $generator;
    }

    /**
     * Choose a single "type" string from the available options.
     *
     * @param null $available
     * @return string
     */
    protected function getRandomType($available = null)
    {
        $available = ($available) ? $available : $this->validTypes;

        return $available[array_rand($available)];
    }
}