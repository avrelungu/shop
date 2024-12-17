<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241209180055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '1.0';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE orders (
          id INT NOT NULL AUTO_INCREMENT,
          user_id INT NOT NULL,
          order_details JSON NOT NULL,
          amount DECIMAL(10, 2) NOT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');

        $this->addSql('CREATE TABLE users (
          id INT NOT NULL AUTO_INCREMENT,
          email VARCHAR(255) NOT NULL,
          name VARCHAR(255) NOT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE users');
    }
}
