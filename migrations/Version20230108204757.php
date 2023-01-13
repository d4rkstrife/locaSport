<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108204757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_material (category_id INT NOT NULL, material_id INT NOT NULL, INDEX IDX_CBC4F1EE12469DE2 (category_id), INDEX IDX_CBC4F1EEE308AC6F (material_id), PRIMARY KEY(category_id, material_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_material ADD CONSTRAINT FK_CBC4F1EE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_material ADD CONSTRAINT FK_CBC4F1EEE308AC6F FOREIGN KEY (material_id) REFERENCES material (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_material DROP FOREIGN KEY FK_CBC4F1EE12469DE2');
        $this->addSql('ALTER TABLE category_material DROP FOREIGN KEY FK_CBC4F1EEE308AC6F');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_material');
    }
}
