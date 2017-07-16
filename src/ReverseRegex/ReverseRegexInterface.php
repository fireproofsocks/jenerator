<?php

namespace Jenerator\ReverseRegex;

interface ReverseRegexInterface
{
    /**
     * Given a regular expression pattern string, return a value that would validate against that pattern
     * @param $string string
     * @return mixed
     */
    public function getValueFromRegex($string);
}