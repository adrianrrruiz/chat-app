<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250928035908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titulo VARCHAR(150) NOT NULL)');
        $this->addSql('CREATE TABLE mensaje (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, persona_id INTEGER NOT NULL, chat_id INTEGER NOT NULL, contenido CLOB NOT NULL, fecha DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_9B631D01F5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9B631D011A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9B631D01F5F88DB9 ON mensaje (persona_id)');
        $this->addSql('CREATE INDEX IDX_9B631D011A9A7125 ON mensaje (chat_id)');
        $this->addSql('CREATE TABLE persona (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE mensaje');
        $this->addSql('DROP TABLE persona');
    }
}
