<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108192943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade ADD material_id INT NOT NULL');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A4366E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('CREATE INDEX IDX_7E1A4366E308AC6F ON trade (material_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A4366E308AC6F');
        $this->addSql('DROP INDEX IDX_7E1A4366E308AC6F ON trade');
        $this->addSql('ALTER TABLE trade DROP material_id');
    }
}
