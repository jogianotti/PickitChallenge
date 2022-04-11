<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220411033207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add owner full name';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE car ADD owner_full_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE car DROP owner_full_name');
    }
}
