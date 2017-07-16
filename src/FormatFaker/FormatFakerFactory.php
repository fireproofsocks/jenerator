<?php

namespace Jenerator\FormatFaker;

use Jenerator\Exceptions\FormatFakerNotDefinedException;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ServiceContainerInterface;

class FormatFakerFactory implements FormatFakerFactoryInterface
{
    /**
     * @var ServiceContainerInterface
     */
    protected $container;

    public function __construct(ServiceContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function getFakeDataForFormat($format, JsonSchemaAccessorInterface $jsonSchemaAccessor)
    {
        // TODO: date-format-
        // TODO: digits, e.g. phonenumber patterns
        try {
            $callable = $this->container->make($format);
            return call_user_func($callable, $jsonSchemaAccessor);
        }
        catch (\Exception $e)
        {
            throw new FormatFakerNotDefinedException('Callback for format "'.$format.'" not defined.', null, $e);
        }
    }

}