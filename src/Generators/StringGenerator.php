<?php

namespace Jenerator\Generators;

use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\RandomString\RandomStringInterface;
use Jenerator\ReverseRegex\ReverseRegexInterface;

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

    /**
     * @var ReverseRegexInterface
     */
    protected $reverseRegex;

    /**
     * @var RandomStringInterface
     */
    protected $randomString;

    public function __construct(FormatFakerFactoryInterface $faker, ReverseRegexInterface $reverseRegex, RandomStringInterface $randomString)
    {
        $this->faker = $faker;
        $this->reverseRegex = $reverseRegex;
        $this->randomString = $randomString;
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
        elseif ($pattern = $this->schemaAccessor->getPattern()) {
            $string = $this->reverseRegex->getValueFromRegex($pattern);
        }
        else {
            $string = $this->randomString->getRandomString($this->schemaAccessor->getMinLength(), $this->schemaAccessor->getMaxLength());
        }

        return strval($string);
    }
}