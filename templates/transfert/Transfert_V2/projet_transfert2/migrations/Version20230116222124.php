<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116222124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transfert (id INT AUTO_INCREMENT NOT NULL, transferts_id INT NOT NULL, statut VARCHAR(45) NOT NULL, mont_transfert DOUBLE PRECISION NOT NULL, mont_benef DOUBLE PRECISION NOT NULL, frais_envoi DOUBLE PRECISION NOT NULL, com_transfert DOUBLE PRECISION NOT NULL, com_agent_livreur DOUBLE PRECISION NOT NULL, nom_benef VARCHAR(45) NOT NULL, num_tel_benef VARCHAR(15) NOT NULL, date_envoi DATETIME NOT NULL, date_pris_charge DATETIME DEFAULT NULL, date_livr DATETIME DEFAULT NULL, is_visible TINYINT(1) NOT NULL, INDEX IDX_1E4EACBB4F2AFE3B (transferts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transfert ADD CONSTRAINT FK_1E4EACBB4F2AFE3B FOREIGN KEY (transferts_id) REFERENCES ville (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transfert DROP FOREIGN KEY FK_1E4EACBB4F2AFE3B');
        $this->addSql('DROP TABLE transfert');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
