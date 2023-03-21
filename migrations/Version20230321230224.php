<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321230224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD id_categ_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66B8CCB787 FOREIGN KEY (id_categ_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66B8CCB787 ON article (id_categ_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66B8CCB787');
        $this->addSql('DROP INDEX IDX_23A0E66B8CCB787 ON article');
        $this->addSql('ALTER TABLE article DROP id_categ_id');
    }
}
