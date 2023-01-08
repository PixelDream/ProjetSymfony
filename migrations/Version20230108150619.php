<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108150619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favory (id INT AUTO_INCREMENT NOT NULL, property_id INT NOT NULL, INDEX IDX_F232B2A8549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favory ADD CONSTRAINT FK_F232B2A8549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE research CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favory DROP FOREIGN KEY FK_F232B2A8549213EC');
        $this->addSql('DROP TABLE favory');
        $this->addSql('ALTER TABLE research CHANGE id id INT NOT NULL');
    }
}
