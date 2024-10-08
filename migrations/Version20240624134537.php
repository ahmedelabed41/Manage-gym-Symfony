<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624134537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP statut');
        $this->addSql('ALTER TABLE programme ADD coach_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF3C105691 FOREIGN KEY (coach_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3DDCB9FF3C105691 ON programme (coach_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation ADD statut VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF3C105691');
        $this->addSql('DROP INDEX IDX_3DDCB9FF3C105691 ON programme');
        $this->addSql('ALTER TABLE programme DROP coach_id');
    }
}
