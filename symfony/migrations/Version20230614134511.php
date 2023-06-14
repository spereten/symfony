<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614134511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE profile (id INT NOT NULL, slug VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, experience VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN profile.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN profile.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, title VARCHAR(64) NOT NULL, lft INT DEFAULT NULL, lvl INT DEFAULT NULL, rgt INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E19D9AD2A977936C ON service (tree_root)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2727ACA70 ON service (parent_id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A977936C FOREIGN KEY (tree_root) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2727ACA70 FOREIGN KEY (parent_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE profile_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('ALTER TABLE service DROP CONSTRAINT FK_E19D9AD2A977936C');
        $this->addSql('ALTER TABLE service DROP CONSTRAINT FK_E19D9AD2727ACA70');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE service');
    }
}
