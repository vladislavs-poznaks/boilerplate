<?php

use DI\ContainerBuilder;
use Doctrine\DBAL\Types\Type;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Doctrine ORM mapping types
Type::addType(\App\Types\CarbonType::NAME, \App\Types\CarbonType::class);
Type::addType(\App\Types\PasswordType::NAME, \App\Types\PasswordType::class);

// IoC container
$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/app.php');
$container = $containerBuilder->build();

return $container;