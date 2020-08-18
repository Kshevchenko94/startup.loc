<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200801153758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE company_contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE goal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, director_id INT NOT NULL, created_id INT NOT NULL, name VARCHAR(64) NOT NULL, email VARCHAR(64) NOT NULL, address VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, state VARCHAR(16) DEFAULT NULL, city VARCHAR(16) DEFAULT NULL, street VARCHAR(128) DEFAULT NULL, house VARCHAR(8) DEFAULT NULL, country VARCHAR(64) DEFAULT NULL, zip_code VARCHAR(64) DEFAULT NULL, office INT DEFAULT NULL, date_created INT NOT NULL, is_active BOOLEAN NOT NULL, web_site VARCHAR(64) NOT NULL, time_work_from VARCHAR(8) DEFAULT NULL, time_work_to VARCHAR(8) DEFAULT NULL, about_company TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4FBF094F899FB366 ON company (director_id)');
        $this->addSql('CREATE INDEX IDX_4FBF094F5EE01E44 ON company (created_id)');
        $this->addSql('CREATE TABLE company_service (company_id INT NOT NULL, service_id INT NOT NULL, PRIMARY KEY(company_id, service_id))');
        $this->addSql('CREATE INDEX IDX_C1CF8005979B1AD6 ON company_service (company_id)');
        $this->addSql('CREATE INDEX IDX_C1CF8005ED5CA9E6 ON company_service (service_id)');
        $this->addSql('CREATE TABLE company_contact (id INT NOT NULL, company_id INT NOT NULL, contact_type_id INT DEFAULT NULL, contact VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6C30FCEF979B1AD6 ON company_contact (company_id)');
        $this->addSql('CREATE INDEX IDX_6C30FCEF5F63AD12 ON company_contact (contact_type_id)');
        $this->addSql('CREATE TABLE contact_type (id INT NOT NULL, name VARCHAR(64) NOT NULL, code VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE goal (id INT NOT NULL, created_id INT DEFAULT NULL, title VARCHAR(130) NOT NULL, description TEXT NOT NULL, date_created INT NOT NULL, price INT NOT NULL, deadline INT DEFAULT NULL, is_private BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FCDCEB2E5EE01E44 ON goal (created_id)');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE skills (id INT NOT NULL, skill VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(64) NOT NULL, first_name VARCHAR(64) NOT NULL, patronymic VARCHAR(64) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F899FB366 FOREIGN KEY (director_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F5EE01E44 FOREIGN KEY (created_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_service ADD CONSTRAINT FK_C1CF8005979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_service ADD CONSTRAINT FK_C1CF8005ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_contact ADD CONSTRAINT FK_6C30FCEF979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_contact ADD CONSTRAINT FK_6C30FCEF5F63AD12 FOREIGN KEY (contact_type_id) REFERENCES contact_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E5EE01E44 FOREIGN KEY (created_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE company_service DROP CONSTRAINT FK_C1CF8005979B1AD6');
        $this->addSql('ALTER TABLE company_contact DROP CONSTRAINT FK_6C30FCEF979B1AD6');
        $this->addSql('ALTER TABLE company_contact DROP CONSTRAINT FK_6C30FCEF5F63AD12');
        $this->addSql('ALTER TABLE company_service DROP CONSTRAINT FK_C1CF8005ED5CA9E6');
        $this->addSql('ALTER TABLE company DROP CONSTRAINT FK_4FBF094F899FB366');
        $this->addSql('ALTER TABLE company DROP CONSTRAINT FK_4FBF094F5EE01E44');
        $this->addSql('ALTER TABLE goal DROP CONSTRAINT FK_FCDCEB2E5EE01E44');
        $this->addSql('DROP SEQUENCE company_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE company_contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE goal_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_service');
        $this->addSql('DROP TABLE company_contact');
        $this->addSql('DROP TABLE contact_type');
        $this->addSql('DROP TABLE goal');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE users');
    }
}
