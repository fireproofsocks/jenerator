<?php

namespace Jenerator\Generators;

/**
 * Interface GeneratorInterface
 * @package Jenerator\Generators
 */
interface GeneratorInterface
{
    /**
     * @param array $schema
     * @return mixed
     */
    public function getValue(array $schema);
}