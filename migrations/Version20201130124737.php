<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201130124737 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mensuration ADD utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE mensuration ADD CONSTRAINT FK_C6AB984AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_C6AB984AFB88E14F ON mensuration (utilisateur_id)');
        $this->addSql('ALTER TABLE poids ADD utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE poids ADD CONSTRAINT FK_D32E8E0DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_D32E8E0DFB88E14F ON poids (utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mensuration DROP FOREIGN KEY FK_C6AB984AFB88E14F');
        $this->addSql('DROP INDEX IDX_C6AB984AFB88E14F ON mensuration');
        $this->addSql('ALTER TABLE mensuration DROP utilisateur_id');
        $this->addSql('ALTER TABLE poids DROP FOREIGN KEY FK_D32E8E0DFB88E14F');
        $this->addSql('DROP INDEX IDX_D32E8E0DFB88E14F ON poids');
        $this->addSql('ALTER TABLE poids DROP utilisateur_id');
    }
}
