<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250801142524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE icon (id INT AUTO_INCREMENT NOT NULL, icon_class VARCHAR(100) NOT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, icon_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(10, 2) NOT NULL, duration VARCHAR(50) NOT NULL, is_featured TINYINT(1) DEFAULT 0 NOT NULL, background_color VARCHAR(50) NOT NULL, text_color VARCHAR(50) NOT NULL, button_color VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E19D9AD254B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_feature (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D05327FAED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD254B9D732 FOREIGN KEY (icon_id) REFERENCES icon (id)');
        $this->addSql('ALTER TABLE service_feature ADD CONSTRAINT FK_D05327FAED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD254B9D732');
        $this->addSql('ALTER TABLE service_feature DROP FOREIGN KEY FK_D05327FAED5CA9E6');
        $this->addSql('DROP TABLE icon');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_feature');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
