<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241016152044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` CHANGE date_modified date_modified DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB0345E237E06 ON `character` (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_41405E395E237E06 ON element (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F62F1765E237E06 ON region (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7758AB085E237E06 ON weapon_category (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_937AB0345E237E06 ON `character`');
        $this->addSql('ALTER TABLE `character` CHANGE date_modified date_modified DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_41405E395E237E06 ON element');
        $this->addSql('DROP INDEX UNIQ_F62F1765E237E06 ON region');
        $this->addSql('DROP INDEX UNIQ_7758AB085E237E06 ON weapon_category');
    }
}
