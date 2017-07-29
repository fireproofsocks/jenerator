<?php

namespace Jenerator\Generators\Object;

use Jenerator\Generators\GeneratorInterface;
use Jenerator\ItemsCalculator\ItemsCalculatorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\Generators\ValueFromSchemaInterface;

class ObjectAdditionalPropertiesGenerator implements GeneratorInterface
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
     * @var ItemsCalculatorInterface
     */
    protected $itemsCalculator;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * ObjectAdditionalPropertiesGenerator constructor.
     * @param GeneratorInterface $next
     * @param ValueFromSchemaInterface $valueGenerator
     * @param ItemsCalculatorInterface $itemsCalculator
     */
    public function __construct(
        GeneratorInterface $next,
        ValueFromSchemaInterface $valueGenerator,
        ItemsCalculatorInterface $itemsCalculator
    ) {
        $this->next = $next;
        $this->valueGenerator = $valueGenerator;
        $this->itemsCalculator = $itemsCalculator;
    }

    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor, $obj = null)
    {
        $this->schemaAccessor = $schemaAccessor;

        $obj = ($obj) ?: new \stdClass();

        $additionalProperties = $this->schemaAccessor->getAdditionalProperties();

        // empty array is valid, but it would evaluate to false
        if ($additionalProperties !== false) {

            $additionalPropertiesCnt = $this->itemsCalculator->getCount(count((array)$obj),
                $this->schemaAccessor->getMinProperties(), $this->schemaAccessor->getMaxProperties());

            for ($i = 0; $i < $additionalPropertiesCnt; $i++) {
                $key = $this->getRandomPropertyName();
                // TODO: this can end up adding zero properties if it happens to return property names that are taken
                if (!property_exists($obj, $key)) {
                    $obj->{$key} = $this->valueGenerator->getExampleValueFromSchema($additionalProperties);
                }
            }
        }

        return $this->next->getGeneratedFakeValue($schemaAccessor, $obj);
    }


    /**
     * TODO: isolate into its own class
     * @return bool|string
     */
    protected function getRandomPropertyName()
    {
        $str = md5(uniqid());
        $len = rand(1, 8);
        return substr($str, 0, $len);
    }
}