<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170114211956 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation ADD topic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('CREATE INDEX IDX_42C849551F55203D ON reservation (topic_id)');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BD9A7F869');
        $this->addSql('DROP INDEX IDX_9D40DE1BD9A7F869 ON topic');
        $this->addSql('ALTER TABLE topic DROP reservations_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849551F55203D');
        $this->addSql('DROP INDEX IDX_42C849551F55203D ON reservation');
        $this->addSql('ALTER TABLE reservation DROP topic_id');
        $this->addSql('ALTER TABLE topic ADD reservations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BD9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_9D40DE1BD9A7F869 ON topic (reservations_id)');
    }
}
