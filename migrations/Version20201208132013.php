<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208132013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787087A2E12');
        $this->addSql('DROP INDEX IDX_6BAF787087A2E12 ON ingredient');
        $this->addSql('ALTER TABLE ingredient DROP composition_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient ADD composition_id INT NOT NULL');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787087A2E12 FOREIGN KEY (composition_id) REFERENCES composition (id)');
        $this->addSql('CREATE INDEX IDX_6BAF787087A2E12 ON ingredient (composition_id)');
    }
}
