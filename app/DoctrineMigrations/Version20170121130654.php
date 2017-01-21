<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170121130654 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE thesis DROP FOREIGN KEY FK_AF4FF3A81F55203D');
        $this->addSql('ALTER TABLE thesis ADD CONSTRAINT FK_AF4FF3A81F55203D FOREIGN KEY (topic_id) REFERENCES topic (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE thesis DROP FOREIGN KEY FK_AF4FF3A81F55203D');
        $this->addSql('ALTER TABLE thesis ADD CONSTRAINT FK_AF4FF3A81F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
    }
}
