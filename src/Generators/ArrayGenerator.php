<?php

namespace Jenerator\Generators;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\UseCases\GetExampleJsonFromSchemaInterface;

class ArrayGenerator implements GeneratorInterface
{
    /**
     * @var GetExampleJsonFromSchemaInterface
     */
    protected $valueGenerator;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * For randomly sized arrays
     * @var int
     */
    protected $max_array_size = 10;

    public function __construct(GetExampleJsonFromSchemaInterface $valueGenerator)
    {
        $this->valueGenerator = $valueGenerator;
    }

    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor)
    {
        $array = [];

        $this->schemaAccessor = $schemaAccessor;

        $itemsSchema = $this->schemaAccessor->getItems();

        if (!$this->isAssociativeArray($itemsSchema)) {
            // tuple
            foreach ($itemsSchema as $schema) {
                $array[] = $this->valueGenerator->getExampleValueFromSchema($schema);
            }
            // additionalItems (only meaningful in the context of a tuple)
            if ($additionalItems = $this->schemaAccessor->getAdditionalItems()) {
                // TODO: verify is boolean false or array
                $cnt = $this->getAdditionalItemsCnt($array);
                for ($i = 0; $i < $cnt; $i++ ) {
                    $array[] = $this->valueGenerator->getExampleValueFromSchema($additionalItems);
                }
            }
        }
        else {
            // standard list
            $cnt = $this->getAdditionalItemsCnt($array);
            for ($i = 0; $i < $cnt; $i++ ) {
                $array[] = $this->valueGenerator->getExampleValueFromSchema($itemsSchema);
            }
        }

        // unique
        if ($schemaAccessor->getUniqueItems()) {
            $array = array_unique($array);
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

    /**
     * How many more items do we need to add to this array?
     * TODO: inject this as its own service?
     * @param array $array
     * @return integer
     */
    protected function getAdditionalItemsCnt(array $array)
    {
        $currentSize = count($array);
        $neededItemsCnt = 0;

        $min = $this->schemaAccessor->getMinItems();
        $min = ($min) ? $min : 0;

        if ($min) {
            if ($currentSize < $min) {
                $neededItemsCnt = $min - $currentSize;
            }
        }
        $max = $this->schemaAccessor->getMaxItems();
        if ($max !== false) {
            if ($currentSize < $max) {
                $neededItemsCnt = rand($min, ($max - $currentSize));
            }
        }
        else {
            // No max defined
            $neededItemsCnt = rand($min, $this->max_array_size);
        }

        return $neededItemsCnt;
    }
}