<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221229075115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id BLOB NOT NULL --(DC2Type:ulid)
        , username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE TABLE user_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (type)');
        $this->addSql('CREATE INDEX object_id_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (created_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_audit');
    }
}
