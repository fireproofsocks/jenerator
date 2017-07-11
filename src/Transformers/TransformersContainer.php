<?php

namespace Jenerator\Transformers;

class TransformersContainer implements TransformersContainerInterface
{
    protected $queue = [];

    /**
     * @inheritdoc
     */
    public function enqueueTransformer(TransformerInterface $transformer)
    {
        $this->queue[] = $transformer;
    }

    /**
     * @inheritdoc
     */
    public function applyTransformations(array $data)
    {
        foreach ($this->queue as $transformer) {
            $data = $transformer->transform($data);
        }

        return $data;
    }

}