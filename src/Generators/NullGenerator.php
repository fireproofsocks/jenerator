<?php

namespace Jenerator\Generators;

class NullGenerator implements GeneratorInterface
{
    /**
     * @inheritdoc
     */
    public function getValue(array $schema)
    {
        return null;
    }

}