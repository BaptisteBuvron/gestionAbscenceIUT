<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211221135032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE group_td (id INT AUTO_INCREMENT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_138B55B139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_tp (id INT AUTO_INCREMENT NOT NULL, group_td_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_1BE26126B718E603 (group_td_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, group_tp_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, INDEX IDX_B723AF33686326CB (group_tp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_td ADD CONSTRAINT FK_138B55B139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE group_tp ADD CONSTRAINT FK_1BE26126B718E603 FOREIGN KEY (group_td_id) REFERENCES group_td (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33686326CB FOREIGN KEY (group_tp_id) REFERENCES group_tp (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_tp DROP FOREIGN KEY FK_1BE26126B718E603');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33686326CB');
        $this->addSql('ALTER TABLE group_td DROP FOREIGN KEY FK_138B55B139DF194');
        $this->addSql('DROP TABLE group_td');
        $this->addSql('DROP TABLE group_tp');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE student');
    }
}
