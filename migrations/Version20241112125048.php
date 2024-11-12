<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241112125048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE application (
                                id INT AUTO_INCREMENT NOT NULL, 
                                car_id INT NOT NULL, 
                                credit_program_id INT NOT NULL, 
                                price INT NOT NULL UNIQUE, 
                                initial_payment NUMERIC(10, 2) UNSIGNED NOT NULL, 
                                monthly_payment NUMERIC(10, 2) UNSIGNED NOT NULL, 
                                INDEX IDX_APPLICATION_CAR_ID (car_id), 
                                INDEX IDX_APPLICATION_CREDIT_PROGRAM_ID (credit_program_id), PRIMARY KEY(id)
                         ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_APPLICATION_CAR_ID FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_APPLICATION_CREDIT_PROGRAM_ID FOREIGN KEY (credit_program_id) REFERENCES credit_program (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_APPLICATION_CAR_ID');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_APPLICATION_CREDIT_PROGRAM_ID');
        $this->addSql('DROP TABLE application');
    }
}
