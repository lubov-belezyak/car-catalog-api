<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241111190103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы с условиями кредитных программ';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE credit_program (
                                id INT AUTO_INCREMENT NOT NULL, 
                                title VARCHAR(255) NOT NULL, 
                                conditions VARCHAR(512) NOT NULL, 
                                interest_rate DOUBLE PRECISION NOT NULL, 
                                min_price INT DEFAULT NULL, 
                                max_price INT DEFAULT NULL, 
                                max_loan_term INT DEFAULT NULL, 
                                min_initial_payment_percentage INT DEFAULT NULL, 
                                max_initial_payment_percentage INT DEFAULT NULL, 
                                PRIMARY KEY(id)
                            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car CHANGE price price INT UNSIGNED NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE credit_program');
        $this->addSql('ALTER TABLE car CHANGE price price NUMERIC(10, 2) NOT NULL');
    }
}
