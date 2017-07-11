<?php

namespace Jenerator\Generators;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\DateTime;
use Faker\Provider\Internet;
use Faker\Provider\Lorem;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

class StringGenerator implements GeneratorInterface
{
    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor, $locale = 'en_US')
    {
        $this->schemaAccessor = $schemaAccessor;

        // TODO: pattern (!!!), minLength, maxLength
        // TODO: support for locale, e.g. default is en_US
        // $maxNbChars = 200
        $format = $this->schemaAccessor->getFormat();

        // @see https://spacetelescope.github.io/understanding-json-schema/reference/string.html
        switch ($format) {
            case 'date-time':
                $string = DateTime::iso8601();
                break;
            case 'email':
                $string = (new Internet(Factory::create($locale)))->email();
                break;
            case 'hostname':
                $string = (new Internet(Factory::create($locale)))->domainName();
                break;
            case 'ipv4':
                $string = (new Internet(Factory::create($locale)))->ipv4();
                break;
            case 'ipv6':
                $string = (new Internet(Factory::create($locale)))->ipv6();
                break;
            case 'uri':
                $string = (new Internet(Factory::create($locale)))->url();
                break;
            default:
                $string = Lorem::text();
        }

        return $string;
    }
}