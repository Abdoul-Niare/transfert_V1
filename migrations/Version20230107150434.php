<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230107150434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transfert ADD ville_id INT NOT NULL');
        $this->addSql('ALTER TABLE transfert ADD CONSTRAINT FK_1E4EACBBA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_1E4EACBBA73F0036 ON transfert (ville_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transfert DROP FOREIGN KEY FK_1E4EACBBA73F0036');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP INDEX IDX_1E4EACBBA73F0036 ON transfert');
        $this->addSql('ALTER TABLE transfert DROP ville_id');
    }
}
