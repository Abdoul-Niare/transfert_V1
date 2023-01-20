<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116224240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transfert ADD expediteur_id INT DEFAULT NULL, ADD agent_livreur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transfert ADD CONSTRAINT FK_1E4EACBB10335F61 FOREIGN KEY (expediteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transfert ADD CONSTRAINT FK_1E4EACBB8922B60E FOREIGN KEY (agent_livreur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1E4EACBB10335F61 ON transfert (expediteur_id)');
        $this->addSql('CREATE INDEX IDX_1E4EACBB8922B60E ON transfert (agent_livreur_id)');
        $this->addSql('ALTER TABLE user ADD villes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649286C17BC FOREIGN KEY (villes_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649286C17BC ON user (villes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transfert DROP FOREIGN KEY FK_1E4EACBB10335F61');
        $this->addSql('ALTER TABLE transfert DROP FOREIGN KEY FK_1E4EACBB8922B60E');
        $this->addSql('DROP INDEX IDX_1E4EACBB10335F61 ON transfert');
        $this->addSql('DROP INDEX IDX_1E4EACBB8922B60E ON transfert');
        $this->addSql('ALTER TABLE transfert DROP expediteur_id, DROP agent_livreur_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649286C17BC');
        $this->addSql('DROP INDEX IDX_8D93D649286C17BC ON user');
        $this->addSql('ALTER TABLE user DROP villes_id');
    }
}
