<?php

namespace Jenerator\Generators;

use Faker\Provider\DateTime;
use Faker\Provider\Internet;
use Faker\Provider\Lorem;

class StringGenerator implements GeneratorInterface
{
    /**
     * @inheritdoc
     */
    public function getValue(array $schema)
    {
        // consider format
        // $maxNbChars = 200
        return Lorem::text();
        // TODO: Implement getValue() method.

        // return Internet::localIpv4();

        //$internet = new Internet();
        //return $internet->ipv6();

        //return $internet->email();

        //$max = 'now';
        //DateTime::iso8601();
    }

}