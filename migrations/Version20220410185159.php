<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220410185159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create owner table and add Owner->Cars relation';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE owner (id VARCHAR(255) NOT NULL, dni VARCHAR(8) NOT NULL, surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD owner_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D7E3C61F9 ON car (owner_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7E3C61F9');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP INDEX IDX_773DE69D7E3C61F9 ON car');
        $this->addSql('ALTER TABLE car DROP owner_id');
    }
}
