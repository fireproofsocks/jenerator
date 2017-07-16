<?php

namespace Jenerator\Generators\Object;

use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\Generators\GeneratorInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ServiceContainerInterface;

class ObjectAdditionalPropertiesGenerator implements GeneratorInterface
{
    /**
     * @var GeneratorInterface
     */
    protected $next;

    /**
     * @var ServiceContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var JsonSchemaAccessorInterface
     */
    protected $schemaAccessor;

    /**
     * TODO: from Config
     * @var int
     */
    protected $maxAdditionalProperties = 10;


    public function __construct(GeneratorInterface $next, ServiceContainerInterface $serviceContainer)
    {
        $this->next = $next;
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @inheritdoc
     */
    public function getGeneratedFakeValue(JsonSchemaAccessorInterface $schemaAccessor, $obj = null)
    {
        $this->schemaAccessor = $schemaAccessor;

        $obj = ($obj) ? $obj : new \stdClass();

        $additionalProperties = $this->schemaAccessor->getAdditionalProperties();

        if ($additionalProperties !== false) {
            $subAccessor = $this->serviceContainer->make(JsonSchemaAccessorFactoryInterface::class)->getJsonSchemaAccessor($additionalProperties);
            $generator = $this->serviceContainer->make(GeneratorFactoryInterface::class)->getGenerator($subAccessor);
            $additionalPropertiesCnt = $this->getAdditionalPropertiesCnt($obj);
            for ($i = 0; $i < $additionalPropertiesCnt; $i++) {
                $key = $this->getRandomPropertyName();
                if (!property_exists($obj, $key)) {
                    $obj->{$key} = $generator->getGeneratedFakeValue($subAccessor);
                }
            }
        }


        return $this->next->getGeneratedFakeValue($schemaAccessor, $obj);
    }

    /**
     * How many more properties should this object have?
     * @param $obj
     * @return int
     */
    protected function getAdditionalPropertiesCnt($obj)
    {
        $currentPropertiesCnt = count(array_keys((array) $obj));

        $min = $this->schemaAccessor->getMinProperties();
        if ($min !== false) {
            if ($min > $currentPropertiesCnt) {
                $min = $min - $currentPropertiesCnt;
            }
        }
        else {
            $min = 0;
        }

        $max = $this->schemaAccessor->getMaxProperties();
        if ($max !== false) {
            if ($max < $currentPropertiesCnt) {
                $max = $max - $currentPropertiesCnt;
            }
        }
        else {
            $max = $this->maxAdditionalProperties;
        }

        return rand($min, $max);
    }

    /**
     * @return bool|string
     */
    protected function getRandomPropertyName()
    {
        $str = md5(uniqid());
        $len = rand(1, 8);
        $name = substr($str,0, $len);
        if ($name === false) {
            $name = 'random'.rand(1,1000);
        }
        return $name;
    }
}