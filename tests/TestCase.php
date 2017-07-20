<?php

namespace JeneratorTest;

use Jenerator\JsonSchemaAccessor\JsonSchemaV4Accessor;
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

    protected function getSchemaAccessor(array $schema = [])
    {
        return (new JsonSchemaV4Accessor())->hydrate($schema);
    }
}