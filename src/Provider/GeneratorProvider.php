<?php

namespace Jenerator\Provider;


use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\Generators\ArrayGenerator;
use Jenerator\Generators\BooleanGenerator;
use Jenerator\Generators\EnumGenerator;
use Jenerator\Generators\IntegerGenerator;
use Jenerator\Generators\NullGenerator;
use Jenerator\Generators\NumberGenerator;
use Jenerator\Generators\Object\ObjectAdditionalPropertiesGenerator;
use Jenerator\Generators\Object\ObjectGeneratorFinal;
use Jenerator\Generators\Object\ObjectPatternPropertiesGenerator;
use Jenerator\Generators\Object\ObjectPropertiesGenerator;
use Jenerator\Generators\Object\ObjectRequiredPropertiesGenerator;
use Jenerator\Generators\StringGenerator;
use Jenerator\ItemsCalculator\ItemsCalculatorInterface;
use Jenerator\RandomString\RandomStringInterface;
use Jenerator\ReverseRegex\ReverseRegexInterface;
use Jenerator\Generators\ValueFromSchemaInterface;
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
            $next = new ObjectPatternPropertiesGenerator($next, $c[ValueFromSchemaInterface::class], $c[ReverseRegexInterface::class]);
            $next = new ObjectRequiredPropertiesGenerator($next, $c[ValueFromSchemaInterface::class]);
            $next = new ObjectAdditionalPropertiesGenerator($next, $c[ValueFromSchemaInterface::class], $c[ItemsCalculatorInterface::class]);
            return new ObjectPropertiesGenerator($next, $c[ValueFromSchemaInterface::class]);

        };
        $container['generator_array'] = function ($c) {
            return new ArrayGenerator($c[ValueFromSchemaInterface::class], $c[ItemsCalculatorInterface::class]);
        };
        $container['generator_string'] = function ($c) {
            return new StringGenerator($c[FormatFakerFactoryInterface::class], $c[ReverseRegexInterface::class], $c[RandomStringInterface::class]);
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