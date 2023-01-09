<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108193414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A43667E3C61F9');
        $this->addSql('DROP INDEX IDX_7E1A43667E3C61F9 ON trade');
        $this->addSql('ALTER TABLE trade DROP owner_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A43667E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7E1A43667E3C61F9 ON trade (owner_id)');
    }
}
