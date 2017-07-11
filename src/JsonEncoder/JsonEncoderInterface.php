<?php

namespace Jenerator\JsonEncoder;

/**
 * Interface JsonEncoderInterface
 *
 * This is required to fix the PHP warts that crop up with empty arrays -- the JSON Schema knows whether it's supposed
 * to be an empty array "[]" or an empty object "{}"
 *
 * @package Jenerator\JsonEncoder
 */
interface JsonEncoderInterface
{
    /**
     * @param $value mixed
     * @param $schema array JSON Schema describing
     * @return string
     */
    public function jsonEncodeValue($value, array $schema);
}