<?php
/*
|--------------------------------------------------------------------------
| Turn on the Lights
|--------------------------------------------------------------------------
|
| Create the application, and register the service providers.
|
*/

require __DIR__.'/../vendor/autoload.php';

$app = new \Jenerator\ServiceContainer();

$app->register(new \Jenerator\Provider\AppServiceProvider());
$app->register(new \Jenerator\Provider\JsonSchemaAccessorProvider());
$app->register(new \Jenerator\Provider\GeneratorProvider());
$app->register(new \Jenerator\Provider\FormatFakerProvider());

return $app;