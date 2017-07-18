<?php

namespace Jenerator\Provider;

use Faker\Factory;
use Faker\Provider\Base;
use Jenerator\FormatFaker\FormatFakerFactory;
use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\Generators\GeneratorFactory;
use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\JsonDecoder\JsonDecoder;
use Jenerator\JsonDecoder\JsonDecoderInterface;
use Jenerator\JsonEncoder\JsonEncoder;
use Jenerator\JsonEncoder\JsonEncoderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactory;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;
use Jenerator\ReferenceResolver\ReferenceResolver;
use Jenerator\ReferenceResolver\ReferenceResolverInterface;
use Jenerator\ReverseRegex\ReverseRegex;
use Jenerator\ReverseRegex\ReverseRegexInterface;
use Jenerator\ServiceContainer;
use Jenerator\UseCases\AppendExamplesToSchema;
use Jenerator\UseCases\AppendExamplesToSchemaInterface;
use Jenerator\UseCases\CreateExampleJsonFilesFromSchema;
use Jenerator\UseCases\CreateExampleJsonFilesFromSchemaInterface;
use Jenerator\UseCases\GetExampleJsonFromSchema;
use Jenerator\UseCases\GetExampleJsonFromSchemaInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AppServiceProvider implements ServiceProviderInterface
{

    /**
     * @inheritDoc
     */
    public function register(Container $container)
    {
        $container[AppendExamplesToSchemaInterface::class] = function () {
            return new AppendExamplesToSchema();
        };

        $container[CreateExampleJsonFilesFromSchemaInterface::class] = function () {
            return new CreateExampleJsonFilesFromSchema();
        };

        $container[GetExampleJsonFromSchemaInterface::class] = function ($c) {
            return new GetExampleJsonFromSchema($c[JsonSchemaAccessorFactoryInterface::class], $c[GeneratorFactoryInterface::class]);
        };

        $container[JsonDecoderInterface::class] = function () {
            return new JsonDecoder();
        };

        $container[JsonEncoderInterface::class] = function () {
            return new JsonEncoder();
        };

        $container[ReverseRegexInterface::class] = function ($c) {
            return new ReverseRegex(new Base(Factory::create(getLocale())));
        };

        $container[ReferenceResolverInterface::class] = function ($c) {
//            return new ReferenceResolver($c[JsonSchemaAccessorFactoryInterface::class]);
            return new ReferenceResolver();
            //return new ReferenceResolver($c);
        };

        // Format Faker Factory
        $container[FormatFakerFactoryInterface::class] = function ($c) {
            // Uses its own container to isolate accessors
            $fakerContainer = new ServiceContainer();
            $fakerContainer->register(new FormatFakerProvider());
            return new FormatFakerFactory($fakerContainer);
        };

        // Json Schema Accessor Factory
        $container[JsonSchemaAccessorFactoryInterface::class] = function ($c) {
            return new JsonSchemaAccessorFactory($c);
        };
//        $container[JsonSchemaAccessorFactoryInterface::class] = $container->factory(function ($c) {
//            return new JsonSchemaAccessorFactory($c);
//        });

        // Generator Factory
        $container[GeneratorFactoryInterface::class] = function ($c) {
            return new GeneratorFactory($c);
        };

    }

}