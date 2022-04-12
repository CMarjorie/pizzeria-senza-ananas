<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412084158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detail_order (id INT AUTO_INCREMENT NOT NULL, pizza_detail_id INT NOT NULL, orders_id INT NOT NULL, quantity INT NOT NULL, total_price DOUBLE PRECISION NOT NULL, INDEX IDX_88D958C15A4E593D (pizza_detail_id), INDEX IDX_88D958C1CFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE extra (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, payment_mode_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, adress_line1 VARCHAR(255) NOT NULL, adress_line2 VARCHAR(255) DEFAULT NULL, postal_code INT NOT NULL, city VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_F52993986EAC8BA0 (payment_mode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_mode (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pizza_detail (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_A6F854774584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pizza_detail_extra (pizza_detail_id INT NOT NULL, extra_id INT NOT NULL, INDEX IDX_8294AA115A4E593D (pizza_detail_id), INDEX IDX_8294AA112B959FC6 (extra_id), PRIMARY KEY(pizza_detail_id, extra_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail_order ADD CONSTRAINT FK_88D958C15A4E593D FOREIGN KEY (pizza_detail_id) REFERENCES pizza_detail (id)');
        $this->addSql('ALTER TABLE detail_order ADD CONSTRAINT FK_88D958C1CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986EAC8BA0 FOREIGN KEY (payment_mode_id) REFERENCES payment_mode (id)');
        $this->addSql('ALTER TABLE pizza_detail ADD CONSTRAINT FK_A6F854774584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE pizza_detail_extra ADD CONSTRAINT FK_8294AA115A4E593D FOREIGN KEY (pizza_detail_id) REFERENCES pizza_detail (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pizza_detail_extra ADD CONSTRAINT FK_8294AA112B959FC6 FOREIGN KEY (extra_id) REFERENCES extra (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pizza_detail_extra DROP FOREIGN KEY FK_8294AA112B959FC6');
        $this->addSql('ALTER TABLE detail_order DROP FOREIGN KEY FK_88D958C1CFFE9AD6');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986EAC8BA0');
        $this->addSql('ALTER TABLE detail_order DROP FOREIGN KEY FK_88D958C15A4E593D');
        $this->addSql('ALTER TABLE pizza_detail_extra DROP FOREIGN KEY FK_8294AA115A4E593D');
        $this->addSql('ALTER TABLE pizza_detail DROP FOREIGN KEY FK_A6F854774584665A');
        $this->addSql('DROP TABLE detail_order');
        $this->addSql('DROP TABLE extra');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE payment_mode');
        $this->addSql('DROP TABLE pizza_detail');
        $this->addSql('DROP TABLE pizza_detail_extra');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
