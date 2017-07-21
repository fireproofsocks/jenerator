<?php

namespace Jenerator\Generators\Object;

use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use Jenerator\Generators\GeneratorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ReverseRegex\ReverseRegexInterface;
use Jenerator\ServiceContainerInterface;
use Jenerator\UseCases\GetExampleJsonFromSchemaInterface;

class ObjectPatternPropertiesGenerator implements GeneratorInterface
{
    /**
     * @var GeneratorInterface
     */
    protected $next;

    /**
     * @var ServiceContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * @var GetExampleJsonFromSchemaInterface
     */
    protected $valueGenerator;

    public function __construct(GeneratorInterface $next, ServiceContainerInterface $serviceContainer)
    {
        $this->next = $next;
        $this->serviceContainer = $serviceContainer;
        $this->valueGenerator = $this->serviceContainer->make(GetExampleJsonFromSchemaInterface::class);
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
                $propertyName = $this->serviceContainer->make(ReverseRegexInterface::class)->getValueFromRegex($pattern);
                $obj->{$propertyName} = $this->valueGenerator->getExampleValueFromSchema($subSchema);
            }
        }

        return $this->next->getGeneratedFakeValue($schemaAccessor, $obj);
    }



}