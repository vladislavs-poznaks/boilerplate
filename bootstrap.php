<?php

use DI\ContainerBuilder;
use Doctrine\DBAL\Types\Type;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Doctrine ORM mapping types
Type::addType(\App\Types\CarbonType::NAME, \App\Types\CarbonType::class);

// IoC container
$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/app.php');
$container = $containerBuilder->build();

return $container;