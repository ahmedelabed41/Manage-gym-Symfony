<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506105816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, type_id_id INT NOT NULL, date_debut VARCHAR(255) NOT NULL, date_fin VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_3DDCB9FF9D86650F (user_id_id), INDEX IDX_3DDCB9FF714819A0 (type_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF714819A0 FOREIGN KEY (type_id_id) REFERENCES type_programme (id)');
        $this->addSql('ALTER TABLE details_programme ADD programme_id INT NOT NULL');
        $this->addSql('ALTER TABLE details_programme ADD CONSTRAINT FK_47DCB52462BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('CREATE INDEX IDX_47DCB52462BB7AEE ON details_programme (programme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_programme DROP FOREIGN KEY FK_47DCB52462BB7AEE');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF9D86650F');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF714819A0');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP INDEX IDX_47DCB52462BB7AEE ON details_programme');
        $this->addSql('ALTER TABLE details_programme DROP programme_id');
    }
}
