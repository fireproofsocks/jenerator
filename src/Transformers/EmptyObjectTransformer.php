<?php

namespace Jenerator\Transformers;

/**
 * Class EmptyObjectTransformer
 *
 * This class exists to remove a PHP wart: empty arrays and empty associative arrays (aka "objects") get json encoded
 * in the same way.  Instead of 'x' => [], this class changes the value to 'x' => new stdClass() when the property is
 * defined as an object.
 *
 * @package Jenerator\Transformers
 */
class EmptyObjectTransformer implements TransformerInterface
{
    /**
     * @inheritdoc
     */
    public function transform(array $data, array $schema)
    {
        // TODO: Implement transform() method.

//        $accessor = $this->schemaAccessorBuilder->getJsonSchemaAccessor($schema);
//
//        $type = $accessor->getType();
//        // multi-type?
//        // if (is_array($type)) { }
//        // is object
//        // is
        return $data;
    }

}