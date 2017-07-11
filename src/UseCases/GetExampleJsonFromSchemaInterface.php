<?php

namespace Jenerator\UseCases;


interface GetExampleJsonFromSchemaInterface
{
    /**
     * Given an associative array representing a JSON Schema, return an example JSON value that is valid against this
     * schema.
     *
     * @param array $schema
     * @return mixed
     */
    public function getExampleJsonFromSchema(array $schema);
}