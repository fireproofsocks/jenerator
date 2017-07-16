<?php

namespace Jenerator\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class PatternProvider
 *
 * Instead of attempting to de-compile regular expressions, they are matched verbatim here in this provider.
 * The callback function mapped should generate values which match against the given regular expression.
 *
 * @see https://github.com/fent/randexp.js
 * @see https://github.com/icomefromthenet/ReverseRegex
 *
 * @package Jenerator\Provider
 */
class PatternProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $container)
    {
        // TODO:
        // Digits
        $container['^[0-9]$'] = $container->protect(function($accessor) {
            $max = $accessor->getMaxLength();
            $max = ($max) ? $max : rand(1, 32);
            $min = $accessor->getMinLength();
            $min = ($min) ? $min : rand(0,31);
            $len = rand($min, $max);

            $out = '';
            for ($i = 0; $i < $len; $i++) {
                $out .= mt_rand(0, 9);
            }

            return $out;
        });
        //$container['^[a-z]$'] = $container->protect(function($accessor) {});
        //$container['^[a-z0-9]$'] = $container->protect(function($accessor) {});
        //$container['^[a-zA-Z]$'] = $container->protect(function($accessor) {});
        //$container['^[a-zA-Z0-9]$'] = $container->protect(function($accessor) {});
    }

}