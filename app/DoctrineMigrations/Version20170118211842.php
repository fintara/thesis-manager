<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170118211842 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE thesis_worker (thesis_id INT NOT NULL, worker_id INT NOT NULL, INDEX IDX_4E68689468D82738 (thesis_id), INDEX IDX_4E6868946B20BA36 (worker_id), PRIMARY KEY(thesis_id, worker_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE thesis_worker ADD CONSTRAINT FK_4E68689468D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thesis_worker ADD CONSTRAINT FK_4E6868946B20BA36 FOREIGN KEY (worker_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE thesis_worker');
    }
}
