<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416125747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates users table';
    }

    public function up(Schema $schema): void
    {
        $users = $schema->createTable('users');

        $users
            ->addColumn('id', Types::BIGINT)
            ->setAutoincrement(true)
            ->setUnsigned(true);

        $users
            ->addColumn('first_name', Types::STRING)
            ->setLength(150);

        $users
            ->addColumn('last_name', Types::STRING)
            ->setLength(150);

        $users
            ->addColumn('email', Types::STRING)
            ->setLength(150);

        $users
            ->addColumn('password', Types::STRING)
            ->setLength(150);

        $users
            ->addColumn('created_at', Types::DATETIME_MUTABLE)
            ->setDefault('CURRENT_TIMESTAMP');

        $users
            ->addColumn('updated_at', Types::DATETIME_MUTABLE)
            ->setColumnDefinition('DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

        $users
            ->setPrimaryKey([
                'id'
            ]);

        $users
            ->addUniqueConstraint([
                'email'
            ]);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('users');
    }
}
