<?php

use App\Middleware\CorsMiddleware;
use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

// Set up settings
$containerBuilder->addDefinitions(__DIR__ . '/container.php');

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Create App instance
$app = $container->get(App::class);

// Register middleware
(require __DIR__ . '/middleware.php')($app);

// Register routes
(require __DIR__ . '/routes.php')($app);

$app->run();