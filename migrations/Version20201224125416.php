<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201224125416 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C444E6803');
        $this->addSql('DROP INDEX IDX_9474526C444E6803 ON comment');
        $this->addSql('ALTER TABLE comment CHANGE episode_id_id episode_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id)');
        $this->addSql('CREATE INDEX IDX_9474526C362B62A0 ON comment (episode_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C362B62A0');
        $this->addSql('DROP INDEX IDX_9474526C362B62A0 ON comment');
        $this->addSql('ALTER TABLE comment CHANGE episode_id episode_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C444E6803 FOREIGN KEY (episode_id_id) REFERENCES episode (id)');
        $this->addSql('CREATE INDEX IDX_9474526C444E6803 ON comment (episode_id_id)');
    }
}
