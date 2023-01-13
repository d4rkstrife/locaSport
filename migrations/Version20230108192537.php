<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108192537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD trade_id INT NOT NULL, ADD date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CC2D9760 FOREIGN KEY (trade_id) REFERENCES trade (id)');
        $this->addSql('CREATE INDEX IDX_9474526CC2D9760 ON comment (trade_id)');
        $this->addSql('ALTER TABLE material ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE75957E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7CBE75957E3C61F9 ON material (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE75957E3C61F9');
        $this->addSql('DROP INDEX IDX_7CBE75957E3C61F9 ON material');
        $this->addSql('ALTER TABLE material DROP owner_id');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CC2D9760');
        $this->addSql('DROP INDEX IDX_9474526CC2D9760 ON comment');
        $this->addSql('ALTER TABLE comment DROP trade_id, DROP date');
    }
}
