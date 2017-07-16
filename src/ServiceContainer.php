<?php

namespace Jenerator;

use Pimple\Container;

/**
 * Class ServiceContainer
 *
 * Abstracting Pimple's container to give us a little distance in case we want to use something other than Pimple.
 *
 * @package Jenerator
 */
class ServiceContainer extends Container implements ServiceContainerInterface
{
    public function make($service)
    {
        return $this->offsetGet($service);
    }
}