<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610090333 extends AbstractMigration
{
    public function getDescription(): string
    {

        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(file_get_contents(__DIR__ . '/database/profile.sql'));
        $this->addSql(file_get_contents(__DIR__ . '/database/service.sql'));
        $this->addSql(file_get_contents(__DIR__ . '/database/profile-service.sql'));

    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table if exists profile');
        $this->addSql('drop table if exists service');
        $this->addSql('drop table if exists profile_service');

    }
}
