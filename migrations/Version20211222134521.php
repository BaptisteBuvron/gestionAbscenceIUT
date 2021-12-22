<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222134521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, absences_report_id INT DEFAULT NULL, late_time INT NOT NULL, is_valid TINYINT(1) DEFAULT NULL, INDEX IDX_765AE0C9CB944F1A (student_id), INDEX IDX_765AE0C989C6A4CE (absences_report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE absences_report (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, course_duration INT NOT NULL, INDEX IDX_5A43C29641807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C989C6A4CE FOREIGN KEY (absences_report_id) REFERENCES absences_report (id)');
        $this->addSql('ALTER TABLE absences_report ADD CONSTRAINT FK_5A43C29641807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C989C6A4CE');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE absences_report');
    }
}
