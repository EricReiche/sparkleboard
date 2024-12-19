<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219150407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id UUID NOT NULL, owner_family_id UUID NOT NULL, icon VARCHAR(255) NOT NULL, color VARCHAR(20) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64C19C1C12525D9 ON category (owner_family_id)');
        $this->addSql('COMMENT ON COLUMN category.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN category.owner_family_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE family (id UUID NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN family.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE family_member (id UUID NOT NULL, family_id UUID NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(20) NOT NULL, picture VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, activation_code VARCHAR(255) DEFAULT NULL, point_balance INT NOT NULL, is_admin BOOLEAN NOT NULL, is_approver BOOLEAN NOT NULL, is_active BOOLEAN NOT NULL, birthday DATE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B9D4AD6DC35E566A ON family_member (family_id)');
        $this->addSql('COMMENT ON COLUMN family_member.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN family_member.family_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE tasks_feed (id UUID NOT NULL, assignee_id UUID DEFAULT NULL, owner_id UUID NOT NULL, category_id UUID NOT NULL, tasks_pool_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, points INT NOT NULL, is_complete BOOLEAN NOT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, scheduled_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, due_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, duration INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C9AFEADD59EC7D60 ON tasks_feed (assignee_id)');
        $this->addSql('CREATE INDEX IDX_C9AFEADD7E3C61F9 ON tasks_feed (owner_id)');
        $this->addSql('CREATE INDEX IDX_C9AFEADD12469DE2 ON tasks_feed (category_id)');
        $this->addSql('CREATE INDEX IDX_C9AFEADD2B797C59 ON tasks_feed (tasks_pool_id)');
        $this->addSql('COMMENT ON COLUMN tasks_feed.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tasks_feed.assignee_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tasks_feed.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tasks_feed.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tasks_feed.tasks_pool_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE tasks_pool (id UUID NOT NULL, category_id UUID NOT NULL, owner_id UUID NOT NULL, assignee_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, points INT NOT NULL, icon VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, is_repeatable BOOLEAN NOT NULL, cadence VARCHAR(2) DEFAULT NULL, cadence_day INT DEFAULT NULL, cadence_overflow BOOLEAN DEFAULT NULL, last_execution TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, next_execution TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_457E07F012469DE2 ON tasks_pool (category_id)');
        $this->addSql('CREATE INDEX IDX_457E07F07E3C61F9 ON tasks_pool (owner_id)');
        $this->addSql('CREATE INDEX IDX_457E07F059EC7D60 ON tasks_pool (assignee_id)');
        $this->addSql('COMMENT ON COLUMN tasks_pool.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tasks_pool.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tasks_pool.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tasks_pool.assignee_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1C12525D9 FOREIGN KEY (owner_family_id) REFERENCES family (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE family_member ADD CONSTRAINT FK_B9D4AD6DC35E566A FOREIGN KEY (family_id) REFERENCES family (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tasks_feed ADD CONSTRAINT FK_C9AFEADD59EC7D60 FOREIGN KEY (assignee_id) REFERENCES family_member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tasks_feed ADD CONSTRAINT FK_C9AFEADD7E3C61F9 FOREIGN KEY (owner_id) REFERENCES family (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tasks_feed ADD CONSTRAINT FK_C9AFEADD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tasks_feed ADD CONSTRAINT FK_C9AFEADD2B797C59 FOREIGN KEY (tasks_pool_id) REFERENCES tasks_pool (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tasks_pool ADD CONSTRAINT FK_457E07F012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tasks_pool ADD CONSTRAINT FK_457E07F07E3C61F9 FOREIGN KEY (owner_id) REFERENCES family (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tasks_pool ADD CONSTRAINT FK_457E07F059EC7D60 FOREIGN KEY (assignee_id) REFERENCES family_member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C1C12525D9');
        $this->addSql('ALTER TABLE family_member DROP CONSTRAINT FK_B9D4AD6DC35E566A');
        $this->addSql('ALTER TABLE tasks_feed DROP CONSTRAINT FK_C9AFEADD59EC7D60');
        $this->addSql('ALTER TABLE tasks_feed DROP CONSTRAINT FK_C9AFEADD7E3C61F9');
        $this->addSql('ALTER TABLE tasks_feed DROP CONSTRAINT FK_C9AFEADD12469DE2');
        $this->addSql('ALTER TABLE tasks_feed DROP CONSTRAINT FK_C9AFEADD2B797C59');
        $this->addSql('ALTER TABLE tasks_pool DROP CONSTRAINT FK_457E07F012469DE2');
        $this->addSql('ALTER TABLE tasks_pool DROP CONSTRAINT FK_457E07F07E3C61F9');
        $this->addSql('ALTER TABLE tasks_pool DROP CONSTRAINT FK_457E07F059EC7D60');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE family_member');
        $this->addSql('DROP TABLE tasks_feed');
        $this->addSql('DROP TABLE tasks_pool');
    }
}
