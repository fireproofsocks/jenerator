<?php

namespace Jenerator\Provider;


use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\Generators\ArrayGenerator;
use Jenerator\Generators\BooleanGenerator;
use Jenerator\Generators\EnumGenerator;
use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\Generators\IntegerGenerator;
use Jenerator\Generators\NullGenerator;
use Jenerator\Generators\NumberGenerator;
use Jenerator\Generators\Object\ObjectAdditionalPropertiesGenerator;
use Jenerator\Generators\Object\ObjectGeneratorFinal;
use Jenerator\Generators\Object\ObjectPatternPropertiesGenerator;
use Jenerator\Generators\Object\ObjectPropertiesGenerator;
use Jenerator\Generators\Object\ObjectRequiredPropertiesGenerator;
use Jenerator\Generators\StringGenerator;
use Jenerator\ReverseRegex\ReverseRegexInterface;
use Jenerator\UseCases\GetExampleJsonFromSchemaInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class GeneratorProvider
 *
 * @package Jenerator\Provider
 */
class GeneratorProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $container)
    {
        // Generator Classes follows convention: generator_{type}
        $container['generator_enum'] = function () {
            return new EnumGenerator();
        };
        $container['generator_object'] = function ($c) {
            // In order to facilitate easier testing and support SRP, we split the creation of objects across
            // a chain of multiple classes
            $next = new ObjectGeneratorFinal();
            $next = new ObjectPatternPropertiesGenerator($next, $c);
            $next = new ObjectRequiredPropertiesGenerator($next, $c);
            $next = new ObjectAdditionalPropertiesGenerator($next, $c);
            return new ObjectPropertiesGenerator($next, $c);

        };
        $container['generator_array'] = function ($c) {
            return new ArrayGenerator($c[GetExampleJsonFromSchemaInterface::class]);
        };
        $container['generator_string'] = function ($c) {
            return new StringGenerator($c[FormatFakerFactoryInterface::class], $c[ReverseRegexInterface::class]);
        };
        $container['generator_number'] = function ($c) {
            return new NumberGenerator();
        };
        $container['generator_integer'] = function ($c) {
            return new IntegerGenerator();
        };
        $container['generator_boolean'] = function () {
            return new BooleanGenerator();
        };
        $container['generator_null'] = function () {
            return new NullGenerator();
        };
    }

}