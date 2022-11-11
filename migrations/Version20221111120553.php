<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221111120553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE content_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE content_type (id INT NOT NULL, type_product_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_41BCBAEC5887B07F ON content_type (type_product_id)');
        $this->addSql('CREATE TABLE type_product (id INT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB6B6B584584665A ON type_product (product_id)');
        $this->addSql('ALTER TABLE content_type ADD CONSTRAINT FK_41BCBAEC5887B07F FOREIGN KEY (type_product_id) REFERENCES type_product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE type_product ADD CONSTRAINT FK_FB6B6B584584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users ADD last_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE content_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_product_id_seq CASCADE');
        $this->addSql('ALTER TABLE content_type DROP CONSTRAINT FK_41BCBAEC5887B07F');
        $this->addSql('ALTER TABLE type_product DROP CONSTRAINT FK_FB6B6B584584665A');
        $this->addSql('DROP TABLE content_type');
        $this->addSql('DROP TABLE type_product');
        $this->addSql('ALTER TABLE "users" DROP first_name');
        $this->addSql('ALTER TABLE "users" DROP last_name');
    }
}
