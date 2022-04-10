<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20220410034915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create cars table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE car (uuid VARCHAR(255) NOT NULL, brand VARCHAR(100) NOT NULL, model VARCHAR(100) NOT NULL, year INT NOT NULL, patent VARCHAR(7) NOT NULL, color VARCHAR(100) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE car');
    }
}
