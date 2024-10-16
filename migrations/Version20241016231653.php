<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241016231653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` CHANGE date_created date_created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE date_modified date_modified DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE release_date release_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` CHANGE date_created date_created DATETIME NOT NULL, CHANGE date_modified date_modified DATETIME NOT NULL, CHANGE release_date release_date DATE NOT NULL');
    }
}
