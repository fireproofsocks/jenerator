<?php

namespace Jenerator;

/**
 * Interface ServiceContainerInterface
 *
 * For resolving service classes - abstracted here so we can change the implementation later if needed.
 *
 * @package Jenerator
 */
interface ServiceContainerInterface
{
    /**
     * Return an implementation of the given interface $service
     * @param $service
     * @return mixed
     */
    public function make($service);
}