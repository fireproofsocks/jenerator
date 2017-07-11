<?php

namespace Jenerator\JsonEncoder;

class JsonEncoder implements JsonEncoderInterface
{
    /**
     * @inheritdoc
     */
    public function jsonEncodeValue($value, array $schema)
    {
        return json_encode($value);
        // TODO: Implement jsonEncodeValue() method.
        //$accessor = $this->schemaAccessorBuilder->getJsonSchemaAccessor($schema);

        //$type = $accessor->getType();
        // multi-type?
        // if (is_array($type)) { }
        // is object
        // is
    }

}