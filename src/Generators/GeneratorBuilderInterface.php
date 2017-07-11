<?php

namespace Jenerator\Generators;

/**
 * Interface GeneratorBuilderInterface
 *
 * Applies logic to determine which Generator class is returned.
 *
 * @package Jenerator\Generators
 */
interface GeneratorBuilderInterface
{
    public function getGenerator($type);
}