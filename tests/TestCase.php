<?php

namespace JeneratorTest;

use Jenerator\ServiceContainerInterface;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceContainerInterface
     */
    protected $container;

    public function __construct()
    {
        $this->container = include __DIR__ .'/../bootstrap/app.php';
        parent::__construct();
    }
}