<?php

namespace Jenerator\Generators;


interface ValueFromSchemaInterface
{
    /**
     * Given an associative array representing a JSON Schema, return an example value that is valid against it.
     *
     * @param array $schema
     * @return mixed
     */
    public function getExampleValueFromSchema(array $schema);
}