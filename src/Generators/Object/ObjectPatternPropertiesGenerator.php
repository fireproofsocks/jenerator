<?php

namespace Jenerator\Generators\Object;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ReverseRegex\ReverseRegexInterface;
use Jenerator\ServiceContainerInterface;
use Jenerator\Generators\ValueFromSchemaInterface;

class ObjectPatternPropertiesGenerator implements GeneratorInterface
{
    /**
     * @var GeneratorInterface
     */
    protected $next;

    /**
     * @var ReverseRegexInterface
     */
    protected $reverseRegex;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * @var ValueFromSchemaInterface
     */
    protected $valueGenerator;

    public function __construct(GeneratorInterface $next, ValueFromSchemaInterface $valueGenerator, ReverseRegexInterface $reverseRegex)
    {
        $this->next = $next;
        $this->reverseRegex = $reverseRegex;
        $this->valueGenerator = $valueGenerator;
    }

    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor, $obj = null)
    {
        $this->schemaAccessor = $schemaAccessor;

        $obj = ($obj) ? $obj : new \stdClass();

        $patternProperties = $this->schemaAccessor->getPatternProperties();

        if ($patternProperties !== false) {
            foreach ($patternProperties as $pattern => $subSchema) {
                // check regular expressions!
                $propertyName = $this->reverseRegex->getValueFromRegex($pattern);
                $obj->{$propertyName} = $this->valueGenerator->getExampleValueFromSchema($subSchema);
            }
        }

        return $this->next->getGeneratedFakeValue($schemaAccessor, $obj);
    }



}