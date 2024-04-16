<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416123459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE thread_comment DROP FOREIGN KEY thread_id');
        $this->addSql('DROP INDEX thread_id_UNIQUE ON thread_comment');
        $this->addSql('ALTER TABLE threads ADD user_comments_json JSON DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE thread_comment ADD CONSTRAINT thread_id FOREIGN KEY (id) REFERENCES threads (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX thread_id_UNIQUE ON thread_comment (thread_id)');
        $this->addSql('ALTER TABLE threads DROP user_comments_json, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
