<?php

namespace Jenerator;

//use Faker\Provider\Miscellaneous;
use Jenerator\Generators\ArrayGenerator;
use Jenerator\Generators\BooleanGenerator;
use Jenerator\Generators\GeneratorBuilder;
use Jenerator\Generators\GeneratorBuilderInterface;
use Jenerator\Generators\GeneratorInterface;
use Jenerator\Generators\IntegerGenerator;
use Jenerator\Generators\NullGenerator;
use Jenerator\Generators\NumberGenerator;
use Jenerator\Generators\ObjectGenerator;
use Jenerator\Generators\StringGenerator;
use Jenerator\JsonDecoder\JsonDecoder;
use Jenerator\JsonDecoder\JsonDecoderInterface;
use Jenerator\JsonEncoder\JsonEncoder;
use Jenerator\JsonEncoder\JsonEncoderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorBuilder;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorBuilderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaV4Accessor;
use Jenerator\Transformers\EmptyObjectTransformer;
use Jenerator\Transformers\TransformersContainer;
use Jenerator\Transformers\TransformersContainerInterface;
use Jenerator\UseCases\AppendExamplesToSchema;
use Jenerator\UseCases\AppendExamplesToSchemaInterface;
use Jenerator\UseCases\CreateExampleJsonFilesFromSchema;
use Jenerator\UseCases\CreateExampleJsonFilesFromSchemaInterface;
use Jenerator\UseCases\GetExampleJsonFromSchema;
use Jenerator\UseCases\GetExampleJsonFromSchemaInterface;
use Pimple\Container;

class ServiceContainer implements ServiceContainerInterface
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct()
    {
        $this->container = new Container();
        $this->init();
    }

    public function make($service)
    {
        return $this->container[$service];
    }

    public function bind($service, \Closure $closure)
    {
        $this->container[$service] = $closure;
    }

    protected function init()
    {

        // Use Cases
        $this->container[AppendExamplesToSchemaInterface::class] = function () {
            return new AppendExamplesToSchema();
        };
        $this->container[CreateExampleJsonFilesFromSchemaInterface::class] = function () {
            return new CreateExampleJsonFilesFromSchema();
        };
        $this->container[GetExampleJsonFromSchemaInterface::class] = function () {
            return new GetExampleJsonFromSchema($this->make(JsonSchemaAccessorBuilderInterface::class), $this->make(GeneratorBuilderInterface::class));
        };

        // Services
        $this->container[JsonDecoderInterface::class] = function () {
            return new JsonDecoder();
        };
        $this->container[JsonEncoderInterface::class] = function () {
            return new JsonEncoder();
        };
        $this->container[TransformersContainerInterface::class] = function () {
            $transformersContainer = new TransformersContainer();
            $transformersContainer->enqueueTransformer(new EmptyObjectTransformer());
            return $transformersContainer;
        };


        // Schema Accessor
        $this->container[JsonSchemaAccessorBuilderInterface::class] = function () {
            return new JsonSchemaAccessorBuilder($this);
        };
        // Accessor classes follows convention: accessor_{$schema}
        $this->container['accessor_http://json-schema.org/draft-04/schema#'] = function () {
            return new JsonSchemaV4Accessor();
        };


        // Generator Builder
        $this->container[GeneratorBuilderInterface::class] = function () {
            return new GeneratorBuilder($this);
        };
        // Generator Classes follows convention: generator_{type}
        $this->container['generator_object'] = function () {
            return new ObjectGenerator($this->make(JsonSchemaAccessorBuilderInterface::class), $this->make(GeneratorBuilderInterface::class));
        };
        $this->container['generator_array'] = function () {
            return new ArrayGenerator($this->make(JsonSchemaAccessorInterface::class), $this->make(GeneratorBuilderInterface::class));
        };
        $this->container['generator_string'] = function () {
            return new StringGenerator();
        };
        $this->container['generator_number'] = function () {
            return new NumberGenerator();
        };
        $this->container['generator_integer'] = function () {
            return new IntegerGenerator();
        };
        $this->container['generator_boolean'] = function () {
            return new BooleanGenerator();
        };
        $this->container['generator_null'] = function () {
            return new NullGenerator();
        };
    }
}