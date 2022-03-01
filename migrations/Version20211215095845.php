<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215095845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ADD artist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_4FBF094FB7970CF8 ON company (artist_id)');
        $this->addSql('ALTER TABLE event ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES event_category (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA712469DE2 ON event (category_id)');
        $this->addSql('ALTER TABLE event_category DROP FOREIGN KEY FK_40A0F01171F7E88B');
        $this->addSql('DROP INDEX IDX_40A0F01171F7E88B ON event_category');
        $this->addSql('ALTER TABLE event_category DROP event_id');
        $this->addSql('ALTER TABLE reward ADD artist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_4ED17253B7970CF8 ON reward (artist_id)');
        $this->addSql('ALTER TABLE study ADD artist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE study ADD CONSTRAINT FK_E67F9749B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_E67F9749B7970CF8 ON study (artist_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FB7970CF8');
        $this->addSql('DROP INDEX IDX_4FBF094FB7970CF8 ON company');
        $this->addSql('ALTER TABLE company DROP artist_id');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA712469DE2');
        $this->addSql('DROP INDEX IDX_3BAE0AA712469DE2 ON event');
        $this->addSql('ALTER TABLE event DROP category_id');
        $this->addSql('ALTER TABLE event_category ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_category ADD CONSTRAINT FK_40A0F01171F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_40A0F01171F7E88B ON event_category (event_id)');
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253B7970CF8');
        $this->addSql('DROP INDEX IDX_4ED17253B7970CF8 ON reward');
        $this->addSql('ALTER TABLE reward DROP artist_id');
        $this->addSql('ALTER TABLE study DROP FOREIGN KEY FK_E67F9749B7970CF8');
        $this->addSql('DROP INDEX IDX_E67F9749B7970CF8 ON study');
        $this->addSql('ALTER TABLE study DROP artist_id');
    }
}
