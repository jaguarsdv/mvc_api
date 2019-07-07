<?php

declare(strict_types=1);

namespace src\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190707070119 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Initial setup';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName()
            !== 'mysql', 'Migration can only be executed safely on \'mysql\'.'
        );

        $sql = <<<SQL
CREATE TABLE `product` (
    `id` CHAR(36) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `create_date` INT UNSIGNED NOT NULL,
    `update_date` INT UNSIGNED NOT NULL,
    PRIMARY KEY(`id`)
)
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
ENGINE = InnoDB;
SQL;
        $this->addSql($sql);

        $sql = <<<SQL
CREATE TABLE `order` (
    `id` CHAR(36) NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `status_id` TINYINT(1) NOT NULL DEFAULT 0,
    `sum` DECIMAL(10,2) NOT NULL,
    `create_date` INT UNSIGNED NOT NULL,
    `update_date` INT UNSIGNED NOT NULL,
    PRIMARY KEY(`id`)
)
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
ENGINE = InnoDB;
SQL;
        $this->addSql($sql);

        $sql = <<<SQL
CREATE TABLE `order_product` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `order_id` CHAR(36) NOT NULL,
    `product_id` CHAR(36) NOT NULL,
    PRIMARY KEY(`id`),
    KEY(`order_id`),
    CONSTRAINT `order_product_order_fk`
        FOREIGN KEY(`order_id`)  REFERENCES `order` (`id`),
    CONSTRAINT `order_product_product_fk`
        FOREIGN KEY(`product_id`)  REFERENCES `product` (`id`)
)
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
ENGINE = InnoDB;
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
