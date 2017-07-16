<?php

namespace Jenerator\Generators\Object;

use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\Generators\GeneratorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ServiceContainerInterface;
use Jenerator\UseCases\GetExampleJsonFromSchemaInterface;

class ObjectRequiredPropertiesGenerator implements GeneratorInterface
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
     * @var GetExampleJsonFromSchemaInterface
     */
    protected $valueGenerator;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    public function __construct(GeneratorInterface $next, ServiceContainerInterface $serviceContainer)
    {
        $this->next = $next;
        $this->serviceContainer = $serviceContainer;
        $this->valueGenerator = $this->serviceContainer->make(GetExampleJsonFromSchemaInterface::class);
    }

    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor, $obj = null)
    {
        $this->schemaAccessor = $schemaAccessor;

        $obj = ($obj) ? $obj : new \stdClass();

        $required = $this->schemaAccessor->getRequired();

        foreach ($required as $r) {

            if (!property_exists($obj, $r)) {
                // http://json-schema.org/latest/json-schema-validation.html#rfc.section.6.19
                // Does its name match any of the pattern properties?
                if ($patternSchema = $this->getSchemaByPattern($r)) {
                    $obj->{$r} = $this->valueGenerator->getExampleValueFromSchema($patternSchema);
                }
                // http://json-schema.org/latest/json-schema-validation.html#rfc.section.6.20
                // Is there an additionalProperties defined?
                elseif ($additionalPropertiesSchema = $this->schemaAccessor->getAdditionalProperties()) {
                    $obj->{$r} = $this->valueGenerator->getExampleValueFromSchema($additionalPropertiesSchema);
                }
                else {
                    // ??? error?
                }

                // propertyNames (v6)
            }
        }

        return $this->next->getGeneratedFakeValue($schemaAccessor, $obj);
    }

    /**
     * @param $candidateField
     * @return bool
     */
    protected function getSchemaByPattern($candidateField)
    {
        if ($patternProperties = $this->schemaAccessor->getPatternProperties()) {
            foreach ($patternProperties as $regex => $schema) {
                if (preg_match('/'.$regex.'/', $candidateField)) {
                    return $schema;
                }
            }
        }
        
        return false;
    }

}