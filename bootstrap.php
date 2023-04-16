<?php

use DI\ContainerBuilder;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// IoC container
$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/app.php');
$container = $containerBuilder->build();

return $container;