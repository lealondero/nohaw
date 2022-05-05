<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405194213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_5A8A6C8D12469DE2');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8D5926566C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, illustration_id, category_id, title, body, published_at, created_at, updated_at FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, illustration_id INTEGER DEFAULT NULL, category_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, body CLOB NOT NULL, published_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , description VARCHAR(255) NOT NULL, CONSTRAINT FK_5A8A6C8D5926566C FOREIGN KEY (illustration_id) REFERENCES illustration (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5A8A6C8D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, illustration_id, category_id, title, body, published_at, created_at, updated_at) SELECT id, illustration_id, category_id, title, body, published_at, created_at, updated_at FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D12469DE2 ON post (category_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8D5926566C ON post (illustration_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_5A8A6C8D5926566C');
        $this->addSql('DROP INDEX IDX_5A8A6C8D12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, illustration_id, category_id, title, body, published_at, created_at, updated_at FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, illustration_id INTEGER DEFAULT NULL, category_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, body CLOB NOT NULL, published_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO post (id, illustration_id, category_id, title, body, published_at, created_at, updated_at) SELECT id, illustration_id, category_id, title, body, published_at, created_at, updated_at FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8D5926566C ON post (illustration_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D12469DE2 ON post (category_id)');
    }
}
