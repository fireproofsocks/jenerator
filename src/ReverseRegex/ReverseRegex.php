<?php

namespace Jenerator\ReverseRegex;

use Faker\Provider\Base;

class ReverseRegex implements ReverseRegexInterface
{
    /**
     * @var Base
     */
    protected $textGenerator;

    public function __construct(Base $textGenerator)
    {
        $this->textGenerator = $textGenerator;
    }

    public function getValueFromRegex($string)
    {
        return $this->textGenerator->regexify($string);
    }

}