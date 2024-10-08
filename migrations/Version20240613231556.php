<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240613231556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image_banniere (id INT AUTO_INCREMENT NOT NULL, banniere_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_69C229B15C272687 (banniere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_banniere ADD CONSTRAINT FK_69C229B15C272687 FOREIGN KEY (banniere_id) REFERENCES banniere (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_banniere DROP FOREIGN KEY FK_69C229B15C272687');
        $this->addSql('DROP TABLE image_banniere');
    }
}
