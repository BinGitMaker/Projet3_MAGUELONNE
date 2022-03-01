<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215092244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist ADD study_id INT DEFAULT NULL, ADD company_id INT DEFAULT NULL, ADD reward_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_1599687E7B003E9 FOREIGN KEY (study_id) REFERENCES study (id)');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_1599687979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_1599687E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id)');
        $this->addSql('CREATE INDEX IDX_1599687E7B003E9 ON artist (study_id)');
        $this->addSql('CREATE INDEX IDX_1599687979B1AD6 ON artist (company_id)');
        $this->addSql('CREATE INDEX IDX_1599687E466ACA1 ON artist (reward_id)');
        $this->addSql('ALTER TABLE event_category ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_category ADD CONSTRAINT FK_40A0F01171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_40A0F01171F7E88B ON event_category (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_1599687E7B003E9');
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_1599687979B1AD6');
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_1599687E466ACA1');
        $this->addSql('DROP INDEX IDX_1599687E7B003E9 ON artist');
        $this->addSql('DROP INDEX IDX_1599687979B1AD6 ON artist');
        $this->addSql('DROP INDEX IDX_1599687E466ACA1 ON artist');
        $this->addSql('ALTER TABLE artist DROP study_id, DROP company_id, DROP reward_id');
        $this->addSql('ALTER TABLE event_category DROP FOREIGN KEY FK_40A0F01171F7E88B');
        $this->addSql('DROP INDEX IDX_40A0F01171F7E88B ON event_category');
        $this->addSql('ALTER TABLE event_category DROP event_id');
    }
}
