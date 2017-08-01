<?php

namespace Jenerator\ReverseRegex;

use RegRev\RegRev;

class ReverseRegexImproved implements ReverseRegexInterface
{
    /**
     * @var RegRev
     */
    protected $generator;

    public function __construct(RegRev $regRev)
    {
        $this->generator = $regRev;
    }

    /**
     * @inheritDoc
     */
    public function getValueFromRegex($string)
    {
        return $this->generator->generate($string);
    }

}