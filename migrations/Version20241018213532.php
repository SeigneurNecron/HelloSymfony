<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241018213532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `character` (id INT AUTO_INCREMENT NOT NULL, element_id INT NOT NULL, weapon_category_id INT NOT NULL, region_id INT NOT NULL, date_created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_modified DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', rare TINYINT(1) NOT NULL, genre VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, version NUMERIC(3, 1) NOT NULL, release_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_937AB0345E237E06 (name), UNIQUE INDEX UNIQ_937AB034989D9B62 (slug), INDEX IDX_937AB0341F1F2A24 (element_id), INDEX IDX_937AB0344011281B (weapon_category_id), INDEX IDX_937AB03498260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE element (id INT AUTO_INCREMENT NOT NULL, color VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_41405E395E237E06 (name), UNIQUE INDEX UNIQ_41405E39989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F62F1765E237E06 (name), UNIQUE INDEX UNIQ_F62F176989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapon_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7758AB085E237E06 (name), UNIQUE INDEX UNIQ_7758AB08989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB0341F1F2A24 FOREIGN KEY (element_id) REFERENCES element (id)');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB0344011281B FOREIGN KEY (weapon_category_id) REFERENCES weapon_category (id)');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB03498260155 FOREIGN KEY (region_id) REFERENCES region (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB0341F1F2A24');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB0344011281B');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB03498260155');
        $this->addSql('DROP TABLE `character`');
        $this->addSql('DROP TABLE element');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE weapon_category');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
