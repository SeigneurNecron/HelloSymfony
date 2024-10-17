<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017021833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB034989D9B62 ON `character` (slug)');
        $this->addSql('ALTER TABLE element ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_41405E39989D9B62 ON element (slug)');
        $this->addSql('ALTER TABLE region ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F62F176989D9B62 ON region (slug)');
        $this->addSql('ALTER TABLE weapon_category ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7758AB08989D9B62 ON weapon_category (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_937AB034989D9B62 ON `character`');
        $this->addSql('ALTER TABLE `character` DROP slug');
        $this->addSql('DROP INDEX UNIQ_41405E39989D9B62 ON element');
        $this->addSql('ALTER TABLE element DROP slug');
        $this->addSql('DROP INDEX UNIQ_F62F176989D9B62 ON region');
        $this->addSql('ALTER TABLE region DROP slug');
        $this->addSql('DROP INDEX UNIQ_7758AB08989D9B62 ON weapon_category');
        $this->addSql('ALTER TABLE weapon_category DROP slug');
    }
}
