<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221111122442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE promotional_code_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE promotional_code (id INT NOT NULL, product_id INT DEFAULT NULL, code VARCHAR(100) NOT NULL, precent INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CF002C2E4584665A ON promotional_code (product_id)');
        $this->addSql('ALTER TABLE promotional_code ADD CONSTRAINT FK_CF002C2E4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C67B3B43D FOREIGN KEY (users_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9474526C67B3B43D ON comment (users_id)');
        $this->addSql('CREATE INDEX IDX_9474526C4584665A ON comment (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE promotional_code_id_seq CASCADE');
        $this->addSql('ALTER TABLE promotional_code DROP CONSTRAINT FK_CF002C2E4584665A');
        $this->addSql('DROP TABLE promotional_code');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C67B3B43D');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C4584665A');
        $this->addSql('DROP INDEX IDX_9474526C67B3B43D');
        $this->addSql('DROP INDEX IDX_9474526C4584665A');
        $this->addSql('ALTER TABLE comment DROP users_id');
        $this->addSql('ALTER TABLE comment DROP product_id');
    }
}
