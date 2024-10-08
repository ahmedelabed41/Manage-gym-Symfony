<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526170701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image_type (id INT AUTO_INCREMENT NOT NULL, type_programme_id INT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_7EE4BDB7E5F8C0EB (type_programme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_type ADD CONSTRAINT FK_7EE4BDB7E5F8C0EB FOREIGN KEY (type_programme_id) REFERENCES type_programme (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_type DROP FOREIGN KEY FK_7EE4BDB7E5F8C0EB');
        $this->addSql('DROP TABLE image_type');
    }
}
