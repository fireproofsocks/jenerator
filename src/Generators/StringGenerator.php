<?php

namespace Jenerator\Generators;

use Faker\Provider\Lorem;
use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
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

    public function __construct(FormatFakerFactoryInterface $faker, ReverseRegexInterface $reverseRegex)
    {
        $this->faker = $faker;
        $this->reverseRegex = $reverseRegex;
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
            $string = $this->getRandomString($this->schemaAccessor->getMinLength(), $this->schemaAccessor->getMaxLength());
        }

        return strval($string);
    }

    /**
     * TODO: put this into its own class
     * @param $min mixed
     * @param $max mixed
     * @return string
     */
    protected function getRandomString($min, $max)
    {
        // TODO: isolate this into its own function
        if ($max) {
            if ($max < 5) {
                $string = substr(Lorem::text(5), 0, $max);

            }
            else {
                $string = Lorem::text($max);
            }
        }
        else {
            $string = Lorem::text();
        }


        if ($min) {
            $len = strlen($string);
            if ($len < $min) {
                $string = $string . $this->getRandomString($min - $len, $min - $len);
            }
        }

        return $string;
    }
}