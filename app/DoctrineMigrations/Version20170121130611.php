<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170121130611 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849551F55203D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955CB944F1A');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551F55203D FOREIGN KEY (topic_id) REFERENCES topic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955CB944F1A FOREIGN KEY (student_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C668D82738');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C670574616');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C668D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C670574616 FOREIGN KEY (reviewer_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B19E9AC5F');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B19E9AC5F FOREIGN KEY (supervisor_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE draft DROP FOREIGN KEY FK_467C969468D82738');
        $this->addSql('ALTER TABLE draft DROP FOREIGN KEY FK_467C9694CB944F1A');
        $this->addSql('ALTER TABLE draft ADD CONSTRAINT FK_467C969468D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE draft ADD CONSTRAINT FK_467C9694CB944F1A FOREIGN KEY (student_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D229445819E9AC5F');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458E2F3C5D1');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445819E9AC5F FOREIGN KEY (supervisor_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458E2F3C5D1 FOREIGN KEY (draft_id) REFERENCES draft (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE draft DROP FOREIGN KEY FK_467C9694CB944F1A');
        $this->addSql('ALTER TABLE draft DROP FOREIGN KEY FK_467C969468D82738');
        $this->addSql('ALTER TABLE draft ADD CONSTRAINT FK_467C9694CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE draft ADD CONSTRAINT FK_467C969468D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id)');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D229445819E9AC5F');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458E2F3C5D1');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445819E9AC5F FOREIGN KEY (supervisor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458E2F3C5D1 FOREIGN KEY (draft_id) REFERENCES draft (id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849551F55203D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955CB944F1A');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C668D82738');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C670574616');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C668D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C670574616 FOREIGN KEY (reviewer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B19E9AC5F');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B19E9AC5F FOREIGN KEY (supervisor_id) REFERENCES user (id)');
    }
}
