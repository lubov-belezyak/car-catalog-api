<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241111191003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand RENAME INDEX unq_brand_name TO UNIQ_1C52F9585E237E06');
        $this->addSql('ALTER TABLE car RENAME INDEX idx_car_brand_id TO IDX_773DE69D44F5D008');
        $this->addSql('ALTER TABLE car RENAME INDEX idx_model_brand_id TO IDX_773DE69D7975B7E7');
        $this->addSql('ALTER TABLE credit_program CHANGE interest_rate interest_rate NUMERIC(4, 1) UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE model RENAME INDEX unq_model_name TO UNIQ_D79572D95E237E06');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car RENAME INDEX idx_773de69d7975b7e7 TO IDX_MODEL_BRAND_ID');
        $this->addSql('ALTER TABLE car RENAME INDEX idx_773de69d44f5d008 TO IDX_CAR_BRAND_ID');
        $this->addSql('ALTER TABLE model RENAME INDEX uniq_d79572d95e237e06 TO UNQ_MODEL_NAME');
        $this->addSql('ALTER TABLE credit_program CHANGE interest_rate interest_rate DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE brand RENAME INDEX uniq_1c52f9585e237e06 TO UNQ_BRAND_NAME');
    }
}
