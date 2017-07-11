<?php

namespace Jenerator\UseCases;

class GetExampleJsonFromSchema implements GetExampleJsonFromSchemaInterface
{
    protected $jsonDecoder;
    protected $jsonEncoder;
    protected $schemaAccessorBuilder;
    protected $generatorBuilder;
    protected $transformersContainer;

    public function getExampleJsonFromSchema(array $schema)
    {
        $accessor = $this->schemaAccessorBuilder->getJsonSchemaAccessor($schema);

        // resolve $ref
        // allOf?? is there a schema hiding in pieces?

        if ($allOf = $accessor->getAllOf()) {
            // merge schema
            $merged = [];
            $accessor->hydrate($merged);
        }

        $generator = $this->generatorBuilder->getGenerator($accessor->getType());

        $value = $generator->getValue($schema);

        // transform value??
        // return encoded value

    }

    public function getExampleJsonFromSchemaFile($filename)
    {
        return $this->getExampleJsonFromSchema($this->jsonDecoder->decodeFile($filename));
    }
}