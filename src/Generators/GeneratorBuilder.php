<?php

namespace Jenerator\Generators;

use Jenerator\Exceptions\InvalidTypeException;
use Jenerator\ServiceContainerInterface;

class GeneratorBuilder implements GeneratorBuilderInterface
{
    protected $serviceContainer;

    protected $validTypes = ['object', 'array', 'string', 'number', 'integer', 'boolean', 'null'];

    public function __construct(ServiceContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @inheritdoc
     */
    public function getGenerator($type)
    {
        // TODO: input should be schema.
        // TODO: evaluate oneOf, anyOf

        if (!$type || is_array($type)) {
            $type = $this->getRandomType($type);
        }

        try {
            $generator = $this->serviceContainer->make('generator_' . $type);
        }
        catch (\Exception $e) {
            throw new InvalidTypeException('The type "'.$type.'" is not a valid JSON Schema type', $e->getCode(), $e);
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

        $item_index = rand(0, count($available));

        return $available[$item_index];
    }
}