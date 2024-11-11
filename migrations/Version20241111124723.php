<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241111124723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create cars, models and brands tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (
                                id INT AUTO_INCREMENT NOT NULL, 
                                name VARCHAR(255) NOT NULL, 
                                PRIMARY KEY(id)
                            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE car (
                                id INT AUTO_INCREMENT NOT NULL, 
                                brand_id INT NOT NULL, 
                                model_id INT NOT NULL, 
                                photo VARCHAR(255) NOT NULL, 
                                price NUMERIC(10, 2) NOT NULL, 
                                INDEX IDX_CAR_BRAND_ID (brand_id), 
                                INDEX IDX_MODEL_BRAND_ID (model_id), 
                                PRIMARY KEY(id)
                            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE model (
                                id INT AUTO_INCREMENT NOT NULL, 
                                name VARCHAR(255) NOT NULL, 
                                PRIMARY KEY(id)
                            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_car_brand_id FOREIGN KEY (brand_id) REFERENCES brand (id)');

        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_car_model_id FOREIGN KEY (model_id) REFERENCES model (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_car_brand_id');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_car_model_id');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE model');
    }
}
