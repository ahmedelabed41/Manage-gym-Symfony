<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514085731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image_exercice (id INT AUTO_INCREMENT NOT NULL, exercice_id INT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_6BE849E589D40298 (exercice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_exercice ADD CONSTRAINT FK_6BE849E589D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
       
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_exercice DROP FOREIGN KEY FK_6BE849E589D40298');
        $this->addSql('DROP TABLE image_exercice');
    }
}
