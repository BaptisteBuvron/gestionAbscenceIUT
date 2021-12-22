<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222233657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, absences_report_id INT DEFAULT NULL, late_time INT DEFAULT NULL, is_valid TINYINT(1) DEFAULT NULL, INDEX IDX_765AE0C9CB944F1A (student_id), INDEX IDX_765AE0C989C6A4CE (absences_report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE absences_report (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, course_duration INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5A43C29641807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE absences_report_student (absences_report_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_8A69D23289C6A4CE (absences_report_id), INDEX IDX_8A69D232CB944F1A (student_id), PRIMARY KEY(absences_report_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, group_parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_parent TINYINT(1) NOT NULL, INDEX IDX_6DC044C5B2C99691 (group_parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, group_class_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, INDEX IDX_B723AF33E330476F (group_class_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT NOT NULL, subject VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C989C6A4CE FOREIGN KEY (absences_report_id) REFERENCES absences_report (id)');
        $this->addSql('ALTER TABLE absences_report ADD CONSTRAINT FK_5A43C29641807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE absences_report_student ADD CONSTRAINT FK_8A69D23289C6A4CE FOREIGN KEY (absences_report_id) REFERENCES absences_report (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absences_report_student ADD CONSTRAINT FK_8A69D232CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5B2C99691 FOREIGN KEY (group_parent_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33E330476F FOREIGN KEY (group_class_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C989C6A4CE');
        $this->addSql('ALTER TABLE absences_report_student DROP FOREIGN KEY FK_8A69D23289C6A4CE');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C5B2C99691');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33E330476F');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9CB944F1A');
        $this->addSql('ALTER TABLE absences_report_student DROP FOREIGN KEY FK_8A69D232CB944F1A');
        $this->addSql('ALTER TABLE absences_report DROP FOREIGN KEY FK_5A43C29641807E1D');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D5BF396750');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE absences_report');
        $this->addSql('DROP TABLE absences_report_student');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE user');
    }
}
