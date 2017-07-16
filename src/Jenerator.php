<?php

namespace Jenerator;

use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\Generators\RandomTypeGenerator;
use Jenerator\JsonDecoder\JsonDecoder;
use Jenerator\JsonDecoder\JsonDecoderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class Jenerator
{
    /**
     * @var JsonDecoder
     */
    protected $jsonDecoder;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * @var GeneratorFactoryInterface
     */
    protected $generatorBuilder;

    public function __construct(JsonDecoderInterface $jsonDecoder, JsonSchemaAccessorInterface $schemaAccessor, GeneratorFactoryInterface $generatorBuilder)
    {
        $this->jsonDecoder = $jsonDecoder;
        $this->schemaAccessor = $schemaAccessor;
        $this->generatorBuilder = $generatorBuilder;
    }

    public function main($filename)
    {
        $schema = $this->jsonDecoder->decodeFile($filename);
        $this->schemaAccessor->factory($schema);

        // allOf?? is there a schema hiding in pieces?
        if ($allOf = $this->schemaAccessor->getAllOf()) {
            // merge schema
            $merged = [];
            $this->schemaAccessor->factory($merged);
        }

        $type = $this->schemaAccessor->getType();

        if (!$type || is_array($type)) {
            // generate random type based on array or on oneOf

        }

        $generator = $this->generatorBuilder->getGenerator($type);

        return $generator->getValue($schema);



    }
}