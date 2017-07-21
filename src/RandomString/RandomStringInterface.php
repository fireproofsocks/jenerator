<?php

namespace Jenerator\RandomString;

/**
 * Interface RandomStringInterface
 *
 * This was needed to add a few more control options than what was available in the Faker methods.
 * Specifically, we needed a random string generator with support for min/max bounds.
 *
 * @package Jenerator\RandomString
 */
interface RandomStringInterface
{
    /**
     * Get a random string of a length described by $minLength and $maxLength
     * @param int $minLength
     * @param int $maxLength
     * @return mixed
     */
    public function getRandomString($minLength = 0, $maxLength = 0);
}