<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029055228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE division_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE result_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE division (id SERIAL NOT NULL, division_name VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE result (id SERIAL NOT NULL, first_team_id INT DEFAULT NULL, second_team_id INT DEFAULT NULL, first_team_score INT NOT NULL, second_team_score INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_136AC1133AE0B452 ON result (first_team_id)');
        $this->addSql('CREATE INDEX IDX_136AC1133E2E58C3 ON result (second_team_id)');
        $this->addSql('CREATE TABLE team (id SERIAL NOT NULL, division_id INT DEFAULT NULL, team_name VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX team_division_id_idx ON team (division_id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1133AE0B452 FOREIGN KEY (first_team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1133E2E58C3 FOREIGN KEY (second_team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F41859289 FOREIGN KEY (division_id) REFERENCES division (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql("insert into public.division (id, division_name) values (1, 'A'), (2, 'B')");
        $this->addSql("insert into public.team (team_name, division_id) values ('A', 1), ('B', 1), ('C', 1), ('D', 1), ('E', 1), ('F', 1), ('G', 1), ('H', 1), ('I', 2), ('J', 2), ('K', 2), ('L', 2), ('M', 2), ('N', 2), ('O', 2), ('P', 2)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE team DROP CONSTRAINT FK_C4E0A61F41859289');
        $this->addSql('ALTER TABLE result DROP CONSTRAINT FK_136AC1133AE0B452');
        $this->addSql('ALTER TABLE result DROP CONSTRAINT FK_136AC1133E2E58C3');
        $this->addSql('DROP SEQUENCE division_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE result_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE team_id_seq CASCADE');
        $this->addSql('DROP TABLE division');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE team');
    }
}
