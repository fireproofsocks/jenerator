<?php
/*
|--------------------------------------------------------------------------
| Turn on the Lights
|--------------------------------------------------------------------------
|
| In this simple app, we use this file to set up autoloading, create the
| application, and register the service providers.
|
*/

require __DIR__.'/../vendor/autoload.php';

$app = new \Jenerator\ServiceContainer();

$app->register(new \Jenerator\Provider\AppServiceProvider());
$app->register(new \Jenerator\Provider\JsonSchemaAccessorProvider());
$app->register(new \Jenerator\Provider\GeneratorProvider());
$app->register(new \Jenerator\Provider\FormatFakerProvider());

return $app;