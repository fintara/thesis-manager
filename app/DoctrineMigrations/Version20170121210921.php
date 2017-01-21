<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170121210921 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE thesis_students (thesis_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_FE385D2468D82738 (thesis_id), INDEX IDX_FE385D24CB944F1A (student_id), PRIMARY KEY(thesis_id, student_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thesis_reviewers (thesis_id INT NOT NULL, worker_id INT NOT NULL, INDEX IDX_2401DF2168D82738 (thesis_id), INDEX IDX_2401DF216B20BA36 (worker_id), PRIMARY KEY(thesis_id, worker_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE thesis_students ADD CONSTRAINT FK_FE385D2468D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thesis_students ADD CONSTRAINT FK_FE385D24CB944F1A FOREIGN KEY (student_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thesis_reviewers ADD CONSTRAINT FK_2401DF2168D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thesis_reviewers ADD CONSTRAINT FK_2401DF216B20BA36 FOREIGN KEY (worker_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE students_theses');
        $this->addSql('DROP TABLE thesis_worker');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE students_theses (student_id INT NOT NULL, thesis_id INT NOT NULL, INDEX IDX_B92699C6CB944F1A (student_id), INDEX IDX_B92699C668D82738 (thesis_id), PRIMARY KEY(student_id, thesis_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thesis_worker (thesis_id INT NOT NULL, worker_id INT NOT NULL, INDEX IDX_4E68689468D82738 (thesis_id), INDEX IDX_4E6868946B20BA36 (worker_id), PRIMARY KEY(thesis_id, worker_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE students_theses ADD CONSTRAINT FK_B92699C668D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_theses ADD CONSTRAINT FK_B92699C6CB944F1A FOREIGN KEY (student_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thesis_worker ADD CONSTRAINT FK_4E68689468D82738 FOREIGN KEY (thesis_id) REFERENCES thesis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thesis_worker ADD CONSTRAINT FK_4E6868946B20BA36 FOREIGN KEY (worker_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE thesis_students');
        $this->addSql('DROP TABLE thesis_reviewers');
    }
}
