<?php

namespace App\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class DatabaseRepository
{
    protected static ?Connection $connection = null;

    protected static ?EntityManager $entityManager = null;

    protected array $connectionParameters = [];

    public function __construct()
    {
        $this->connectionParameters = [
            'dbname' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'driver' => 'pdo_mysql',
        ];
    }

    public static function connection(): Connection
    {
        if (is_null(static::$connection)) {
            $repository = new self();

            static::$connection = $repository->getConnection();
        }

        return static::$connection;
    }

    public static function entityManager(): EntityManager
    {
        if (is_null(static::$entityManager)) {
            static::$entityManager = new EntityManager(
                static::connection(),
                ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/../Models'])
            );
        }

        return static::$entityManager;
    }

    private function getConnection(): Connection
    {
        return DriverManager::getConnection($this->connectionParameters);
    }
}