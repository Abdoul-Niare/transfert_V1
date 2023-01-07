<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230107154624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transfert ADD agent_livreur_id INT NOT NULL');
        $this->addSql('ALTER TABLE transfert ADD CONSTRAINT FK_1E4EACBB8922B60E FOREIGN KEY (agent_livreur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1E4EACBB8922B60E ON transfert (agent_livreur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transfert DROP FOREIGN KEY FK_1E4EACBB8922B60E');
        $this->addSql('DROP INDEX IDX_1E4EACBB8922B60E ON transfert');
        $this->addSql('ALTER TABLE transfert DROP agent_livreur_id');
    }
}
