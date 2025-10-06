<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251006031811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__mensaje AS SELECT id, persona_id, chat_id, contenido, fecha FROM mensaje');
        $this->addSql('DROP TABLE mensaje');
        $this->addSql('CREATE TABLE mensaje (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, persona_id INTEGER NOT NULL, chat_id INTEGER NOT NULL, contenido CLOB NOT NULL, fecha DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_9B631D01F5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9B631D011A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO mensaje (id, persona_id, chat_id, contenido, fecha) SELECT id, persona_id, chat_id, contenido, fecha FROM __temp__mensaje');
        $this->addSql('DROP TABLE __temp__mensaje');
        $this->addSql('CREATE INDEX IDX_9B631D011A9A7125 ON mensaje (chat_id)');
        $this->addSql('CREATE INDEX IDX_9B631D01F5F88DB9 ON mensaje (persona_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__persona AS SELECT id, nombre FROM persona');
        $this->addSql('DROP TABLE persona');
        $this->addSql('CREATE TABLE persona (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, telefono VARCHAR(20) NOT NULL)');
        $this->addSql('INSERT INTO persona (id, nombre) SELECT id, nombre FROM __temp__persona');
        $this->addSql('DROP TABLE __temp__persona');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51E5B69BC1E70A7F ON persona (telefono)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__mensaje AS SELECT id, persona_id, chat_id, contenido, fecha FROM mensaje');
        $this->addSql('DROP TABLE mensaje');
        $this->addSql('CREATE TABLE mensaje (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, persona_id INTEGER NOT NULL, chat_id INTEGER NOT NULL, contenido CLOB NOT NULL, fecha DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_9B631D01F5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9B631D011A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO mensaje (id, persona_id, chat_id, contenido, fecha) SELECT id, persona_id, chat_id, contenido, fecha FROM __temp__mensaje');
        $this->addSql('DROP TABLE __temp__mensaje');
        $this->addSql('CREATE INDEX IDX_9B631D01F5F88DB9 ON mensaje (persona_id)');
        $this->addSql('CREATE INDEX IDX_9B631D011A9A7125 ON mensaje (chat_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__persona AS SELECT id, nombre FROM persona');
        $this->addSql('DROP TABLE persona');
        $this->addSql('CREATE TABLE persona (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO persona (id, nombre) SELECT id, nombre FROM __temp__persona');
        $this->addSql('DROP TABLE __temp__persona');
    }
}
