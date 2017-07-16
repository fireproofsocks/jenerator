<?php

namespace Jenerator\Provider;

use Jenerator\JsonSchemaAccessor\JsonSchemaV4Accessor;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class JsonSchemaAccessorProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     *
     * For valid Schema urls, see
     * @see https://spacetelescope.github.io/understanding-json-schema/reference/schema.html
     */
    public function register(Container $container)
    {
        // convention: accessor_{url}
        // Register new accessors by their $schema URL (they should implement the JsonSchemaAccessorInterface)
        $container['accessor_http://json-schema.org/draft-04/schema#'] = $container->factory(function () {
            return new JsonSchemaV4Accessor();
        });
    }

}