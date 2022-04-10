<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220410160309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Car->Transactions relation';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE car DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE car CHANGE uuid id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE car ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE transaction DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE transaction ADD car_id VARCHAR(255) DEFAULT NULL, CHANGE uuid id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_723705D1C3C6F69F ON transaction (car_id)');
        $this->addSql('ALTER TABLE transaction ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE car DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE car CHANGE id uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE car ADD PRIMARY KEY (uuid)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1C3C6F69F');
        $this->addSql('DROP INDEX IDX_723705D1C3C6F69F ON transaction');
        $this->addSql('ALTER TABLE transaction DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE transaction DROP car_id, CHANGE id uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD PRIMARY KEY (uuid)');
    }
}
