<?php

namespace Jenerator\ReverseRegex;

use Faker\Provider\Base;

/**
 * Class ReverseRegex
 *
 * This implementation relies on the Faker package's functionality to reverse-engineer regular expressions.
 *
 * @package Jenerator\ReverseRegex
 */
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

    /**
     * @inheritdoc
     */
    public function getValueFromRegex($string)
    {
        return $this->textGenerator->regexify($string);
    }

}