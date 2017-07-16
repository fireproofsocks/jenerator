<?php

namespace Jenerator\Generators;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\DateTime;
use Faker\Provider\Internet;
use Faker\Provider\Lorem;
use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class StringGenerator implements GeneratorInterface
{
    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * @var FormatFakerFactoryInterface
     */
    protected $faker;

    public function __construct(FormatFakerFactoryInterface $faker)
    {
        $this->faker = $faker;
    }

    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor, $locale = 'en_US')
    {
        $this->schemaAccessor = $schemaAccessor;

        if ($format = $this->schemaAccessor->getFormat()) {
            $string = $this->faker->getFakeDataForFormat($format, $this->schemaAccessor);
        }
        else {
            $string = Lorem::text();
        }
        // TODO: pattern (!!!), minLength, maxLength

        return strval($string);
    }
}