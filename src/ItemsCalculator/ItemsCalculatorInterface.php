<?php

namespace Jenerator\ItemsCalculator;

/**
 * Interface ItemsCalculatorInterface
 *
 * Implementations of this interface calculate how many more items can be added to the given thing,
 * bounded by a $min and $max.  E.g. if the $current_cnt is 3 and the $max is 4, then the result
 * should be 1.  Randomization is possible here: there's no requirement that we fill the thing.
 *
 * @package Jenerator\AdditionalItems
 */
interface ItemsCalculatorInterface
{

    /**
     * Get a count of how many more items can be added to the $current_cnt given the bounds of $min, $max.
     * @param $current_cnt integer
     * @param $min integer
     * @param $max integer
     * @return integer
     */
    public function getCount($current_cnt = 0, $min = 0, $max = 0);
}