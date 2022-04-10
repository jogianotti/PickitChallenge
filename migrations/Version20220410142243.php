<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220410142243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create transactions table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE transaction (uuid VARCHAR(255) NOT NULL, services LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE transaction');
    }
}
