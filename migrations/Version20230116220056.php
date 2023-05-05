<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116220056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, discussion_id INT NOT NULL, participant_id INT NOT NULL, INDEX IDX_AB55E24F1ADED311 (discussion_id), INDEX IDX_AB55E24F9D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F9D1C3019 FOREIGN KEY (participant_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F1ADED311');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F9D1C3019');
        $this->addSql('DROP TABLE participation');
    }
}
