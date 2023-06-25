<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230625153100 extends AbstractMigration
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
        $this->addSql('CREATE INDEX profile__slug__inx ON profile (slug)');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, parent_id INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(64) NOT NULL, root INT DEFAULT NULL, lvl INT NOT NULL, lft INT NOT NULL, rgt INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX service__parent_id__inx ON service (parent_id)');
        $this->addSql('CREATE TABLE service_profile (service_id INT NOT NULL, profile_id INT NOT NULL, PRIMARY KEY(service_id, profile_id))');
        $this->addSql('CREATE INDEX IDX_4ED3F893ED5CA9E6 ON service_profile (service_id)');
        $this->addSql('CREATE INDEX IDX_4ED3F893CCFA12B8 ON service_profile (profile_id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2727ACA70 FOREIGN KEY (parent_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_profile ADD CONSTRAINT FK_4ED3F893ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_profile ADD CONSTRAINT FK_4ED3F893CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE profile_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('ALTER TABLE service DROP CONSTRAINT FK_E19D9AD2727ACA70');
        $this->addSql('ALTER TABLE service_profile DROP CONSTRAINT FK_4ED3F893ED5CA9E6');
        $this->addSql('ALTER TABLE service_profile DROP CONSTRAINT FK_4ED3F893CCFA12B8');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_profile');
    }
}
