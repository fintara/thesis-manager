<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170114211810 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE draft (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, thesis_id INT DEFAULT NULL, filename VARCHAR(100) NOT NULL, version INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_467C9694CB944F1A (student_id), INDEX IDX_467C969468D82738 (thesis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, supervisor_id INT DEFAULT NULL, draft_id INT DEFAULT NULL, content LONGTEXT NOT NULL, filename VARCHAR(100) NOT NULL, INDEX IDX_D229445819E9AC5F (supervisor_id), UNIQUE INDEX UNIQ_D2294458E2F3C5D1 (draft_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, status INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_42C84955CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, thesis_id INT DEFAULT NULL, reviewer_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, grade DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, filename VARCHAR(100) NOT NULL, INDEX IDX_794381C668D82738 (thesis_id), INDEX IDX_794381C670574616 (reviewer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students_theses (student_id INT NOT NULL, thesis_id INT NOT NULL, INDEX IDX_B92699C6CB944F1A (student_id), INDEX IDX_B92699C668D82738 (thesis_id), PRIMARY KEY(student_id, thesis_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thesis (id INT AUTO_INCREMENT NOT NULL, topic_id INT DEFAULT NULL, title VARCHAR(200) NOT NULL, INDEX IDX_AF4FF3A81F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, supervisor_id INT DEFAULT NULL, reservations_id INT DEFAULT NULL, title VARCHAR(150) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_9D40DE1B19E9AC5F (supervisor_id), INDEX IDX_9D40DE1BD9A7F869 (reservations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE draft ADD CONSTRAINT FK_467C9694CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE draft ADD CONSTRAINT FK_467C969468D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445819E9AC5F FOREIGN KEY (supervisor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458E2F3C5D1 FOREIGN KEY (draft_id) REFERENCES draft (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C668D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C670574616 FOREIGN KEY (reviewer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE students_theses ADD CONSTRAINT FK_B92699C6CB944F1A FOREIGN KEY (student_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_theses ADD CONSTRAINT FK_B92699C668D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thesis ADD CONSTRAINT FK_AF4FF3A81F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B19E9AC5F FOREIGN KEY (supervisor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BD9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservation (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458E2F3C5D1');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BD9A7F869');
        $this->addSql('ALTER TABLE draft DROP FOREIGN KEY FK_467C969468D82738');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C668D82738');
        $this->addSql('ALTER TABLE students_theses DROP FOREIGN KEY FK_B92699C668D82738');
        $this->addSql('ALTER TABLE thesis DROP FOREIGN KEY FK_AF4FF3A81F55203D');
        $this->addSql('DROP TABLE draft');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE students_theses');
        $this->addSql('DROP TABLE thesis');
        $this->addSql('DROP TABLE topic');
    }
}
