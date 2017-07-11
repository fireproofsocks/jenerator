<?php

namespace Jenerator\Transformers;

interface TransformerInterface
{
    /**
     * Transform the input $data according to the defined $schema
     * @param array $data
     * @param array $schema
     * @return array
     */
    public function transform(array $data, array $schema);
}