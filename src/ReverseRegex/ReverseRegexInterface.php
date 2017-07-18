<?php

namespace Jenerator\ReverseRegex;

interface ReverseRegexInterface
{
    /**
     * Given a regular expression pattern string, return a value that would validate against that pattern
     *
     * Some other libraries accomplish this (in various languages):
     *
     * @see https://github.com/fent/randexp.js
     * @see https://github.com/icomefromthenet/ReverseRegex
     * @see https://code.google.com/archive/p/xeger/
     *
     * @param $string string
     * @return mixed
     */
    public function getValueFromRegex($string);
}