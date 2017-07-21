<?php

namespace Jenerator\Provider;

use Faker\Factory;
use Faker\Provider\Lorem;
use Jenerator\FormatFaker\FormatFakerFactory;
use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\Generators\GeneratorFactory;
use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\ItemsCalculator\ItemsCalculator;
use Jenerator\ItemsCalculator\ItemsCalculatorInterface;
use Jenerator\JsonDecoder\JsonDecoder;
use Jenerator\JsonDecoder\JsonDecoderInterface;
use Jenerator\JsonEncoder\JsonEncoder;
use Jenerator\JsonEncoder\JsonEncoderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactory;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;
use Jenerator\RandomString\RandomString;
use Jenerator\RandomString\RandomStringInterface;
use Jenerator\ReferenceResolver\ReferenceResolver;
use Jenerator\ReferenceResolver\ReferenceResolverInterface;
use Jenerator\ReverseRegex\ReverseRegexImproved;
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
use RegRev\RegRev;

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

        $container[ItemsCalculatorInterface::class] = function ($c) {
            return new ItemsCalculator();
        };

        $container[JsonDecoderInterface::class] = function () {
            return new JsonDecoder();
        };

        $container[RandomStringInterface::class] = function ($c) {
            return new RandomString(new Lorem(Factory::create(getLocale())));
        };

        $container[ReverseRegexInterface::class] = function ($c) {
            return new ReverseRegexImproved(new RegRev());
        };

        $container[ReferenceResolverInterface::class] = function ($c) {
            return new ReferenceResolver();
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

        // Generator Factory
        $container[GeneratorFactoryInterface::class] = function ($c) {
            return new GeneratorFactory($c);
        };

    }

}