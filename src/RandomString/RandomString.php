<?php

namespace Jenerator\RandomString;

use Faker\Provider\Lorem;

class RandomString implements RandomStringInterface
{
    /**
     * @var Lorem
     */
    protected $generator;

    public function __construct(Lorem $lorem)
    {
        $this->generator = $lorem;
    }

    /**
     * @inheritDoc
     */
    public function getRandomString($minLength = 0, $maxLength = 0)
    {
        if ($maxLength) {
            if ($maxLength < 5) {
                $string = substr($this->generator->text(5), 0, $maxLength);

            }
            else {
                $string = $this->generator->text($maxLength);
            }
        }
        else {
            $string = $this->generator->text();
        }


        if ($minLength) {
            $len = strlen($string);
            if ($len < $minLength) {
                $string = $string . $this->getRandomString($minLength - $len, $minLength - $len);
            }
        }

        return $string;
    }

}