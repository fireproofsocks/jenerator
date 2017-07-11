<?php

namespace Jenerator\Transformers;

interface TransformersContainerInterface
{
    /**
     * Add a transformer to the queue
     * @param TransformerInterface $transformer
     * @return mixed
     */
    public function enqueueTransformer(TransformerInterface $transformer);

    /**
     * Loop over all enqueued Transformers, apply the transformations to input $data
     * @param array $data
     * @return array
     */
    public function applyTransformations(array $data);
}