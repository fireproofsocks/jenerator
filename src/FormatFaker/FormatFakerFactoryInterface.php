<?php

namespace Jenerator\FormatFaker;

use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;

interface FormatFakerFactoryInterface
{
    /**
     * Get the fake data in the given $format
     * @param $format string
     * @param JsonSchemaAccessorInterface $jsonSchemaAccessor
     * @return mixed
     */
    public function getFakeDataForFormat($format, JsonSchemaAccessorInterface $jsonSchemaAccessor);
}