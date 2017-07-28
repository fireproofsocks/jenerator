<?php

namespace Jenerator\Generators\Object;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\Generators\ValueFromSchemaInterface;

/**
 * Class ObjectRequiredPropertiesGenerator
 *
 * The job of this class is to create on the object all properties listed in the schema's "required" array
 * that did not have explicit schemas defined for them in the "properties" object.
 * Properties are generated from "patternProperties" or by the schema defined in the "additionalProperties".
 *
 * This class should solve for the case like this:
 * {
 *   "type": "object",
 *   "required": ["str_name", "some_extra"],
 *   "patternProperties": {
 *       "^str_.*": {"type": "string"},
 *   },
 *   "additionalProperties": {
 *      {"type": "string"}
 *   }
 * }
 *
 * @package Jenerator\Generators\Object
 */
class ObjectRequiredPropertiesGenerator implements GeneratorInterface
{
    /**
     * @var GeneratorInterface
     */
    protected $next;

    /**
     * @var ValueFromSchemaInterface
     */
    protected $valueGenerator;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    public function __construct(GeneratorInterface $next, ValueFromSchemaInterface $valueGenerator)
    {
        $this->next = $next;
        $this->valueGenerator = $valueGenerator;
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
                    // ??? error???
                }

                // TODO: propertyNames (v6)
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