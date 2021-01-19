<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207130232 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mensuration');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mensuration (id INT AUTO_INCREMENT NOT NULL, zone_corps_id INT NOT NULL, utilisateur_id INT NOT NULL, mesure DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, date DATE NOT NULL, INDEX IDX_C6AB984A31B697F5 (zone_corps_id), INDEX IDX_C6AB984AFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mensuration ADD CONSTRAINT FK_C6AB984A31B697F5 FOREIGN KEY (zone_corps_id) REFERENCES zone_corps (id)');
        $this->addSql('ALTER TABLE mensuration ADD CONSTRAINT FK_C6AB984AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }
}
