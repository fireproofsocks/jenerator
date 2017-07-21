<?php

namespace Jenerator\Generators;

use Jenerator\ItemsCalculator\ItemsCalculatorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\UseCases\GetExampleJsonFromSchemaInterface;

class ArrayGenerator implements GeneratorInterface
{
    /**
     * @var GetExampleJsonFromSchemaInterface
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
     * For randomly sized arrays
     * @var int
     */
    protected $max_array_size = 10;

    public function __construct(GetExampleJsonFromSchemaInterface $valueGenerator, ItemsCalculatorInterface $itemsCalculator)
    {
        $this->valueGenerator = $valueGenerator;
        $this->itemsCalculator = $itemsCalculator;
    }

    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor)
    {
        $this->schemaAccessor = $schemaAccessor;

        $itemsSchema = $this->schemaAccessor->getItems();

        $array = ($this->isAssociativeArray($itemsSchema)) ? $this->generateList($itemsSchema) : $this->generateTuple($itemsSchema);

        return ($schemaAccessor->getUniqueItems()) ? array_unique($array) : $array;
    }

    /**
     * Generate a tuple, where the nth item validates against the nth schema.
     * @param $itemsSchema array
     * @return array
     */
    protected function generateTuple(array $itemsSchema)
    {
        $array = [];

        $additionalItems = $this->schemaAccessor->getAdditionalItems();

        $cnt = $this->itemsCalculator->getCount(0, $this->schemaAccessor->getMinItems(), $this->schemaAccessor->getMaxItems());

        for ($i = 0; $i < $cnt; $i++ ) {
            if (isset($itemsSchema[$i])) {
                $array[] = $this->valueGenerator->getExampleValueFromSchema($itemsSchema[$i]);
            }
            elseif ($additionalItems) {
                $array[] = $this->valueGenerator->getExampleValueFromSchema($additionalItems);
            }
            else {
                // ??? if you require a minimum # of items but additionalItems is false ???
            }
        }

        return $array;
    }

    /**
     * Generate a standard list where each item validates against the same schema.
     * @param array $itemsSchema
     * @return array
     */
    protected function generateList(array $itemsSchema)
    {
        // standard list
        $cnt = $this->itemsCalculator->getCount(0, $this->schemaAccessor->getMinItems(), $this->schemaAccessor->getMaxItems());
        for ($i = 0; $i < $cnt; $i++ ) {
            $array[] = $this->valueGenerator->getExampleValueFromSchema($itemsSchema);
        }

        return $array;
    }

    /**
     * @see https://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential
     * @param array $array
     * @return bool
     */
    protected function isAssociativeArray(array $array)
    {
        if ([] === $array) return true;
        return array_keys($array) !== range(0, count($array) - 1);
    }
}