<?php

namespace Jenerator\ItemsCalculator;

class ItemsCalculator implements ItemsCalculatorInterface
{
    /**
     * For unbounded calculations where no max is provided, use this number
     * @var int
     */
    protected $max_size = 10;

    /**
     * @inheritDoc
     */
    public function getCount($current_cnt = 0, $min = 0, $max = 0)
    {
        $neededItemsCnt = 0;

        if ($min) {
            if ($current_cnt < $min) {
                $neededItemsCnt = $min - $current_cnt;
            }
        }

        if ($max) {
            if ($current_cnt < $max) {
                $neededItemsCnt = rand($neededItemsCnt, ($max - $current_cnt));
            }
        }
        else {
            // No max defined
            $neededItemsCnt = rand($min, $this->max_size);
        }

        return $neededItemsCnt;
    }

}