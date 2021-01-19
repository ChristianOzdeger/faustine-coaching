<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201130104622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mensuration ADD zone_corps_id INT NOT NULL');
        $this->addSql('ALTER TABLE mensuration ADD CONSTRAINT FK_C6AB984A31B697F5 FOREIGN KEY (zone_corps_id) REFERENCES zone_corps (id)');
        $this->addSql('CREATE INDEX IDX_C6AB984A31B697F5 ON mensuration (zone_corps_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mensuration DROP FOREIGN KEY FK_C6AB984A31B697F5');
        $this->addSql('DROP INDEX IDX_C6AB984A31B697F5 ON mensuration');
        $this->addSql('ALTER TABLE mensuration DROP zone_corps_id');
    }
}
